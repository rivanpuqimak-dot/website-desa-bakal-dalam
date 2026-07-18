<?php

namespace App\Http\Controllers\Admin\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun administrator.
     */
    public function index(Request $request): View
    {
        $this->ensureAuthorized();

        $users = $this->userQuery($request)
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.user.index',
            compact('users')
        );
    }

    /**
     * Menyimpan akun administrator baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureAuthorized();

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],
                'role' => [
                    'required',
                    Rule::in([
                        'Super Admin',
                        'Admin',
                        'Editor',
                    ]),
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
                'foto' => [
                    'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ],
            $this->validationMessages()
        );

        $photoPath = null;

        try {
            if ($request->hasFile('foto')) {
                $photo = $request->file('foto');

                if (!$photo || !$photo->isValid()) {
                    throw new \RuntimeException(
                        'Foto profil tidak valid.'
                    );
                }

                $photoPath = $photo->store(
                    'users',
                    'public'
                );

                if (!$photoPath) {
                    throw new \RuntimeException(
                        'Foto profil gagal disimpan.'
                    );
                }
            }

            DB::transaction(function () use (
                $validated,
                $photoPath
            ): void {
                User::create([
                    'name' => trim($validated['name']),
                    'email' => strtolower(
                        trim($validated['email'])
                    ),
                    'role' => $validated['role'],
                    'password' => Hash::make(
                        $validated['password']
                    ),
                    'foto' => $photoPath,
                ]);
            });

            return redirect()
                ->route('admin.users')
                ->with(
                    'success',
                    'Akun administrator berhasil ditambahkan.'
                );
        } catch (Throwable $exception) {
            if (
                $photoPath &&
                Storage::disk('public')->exists($photoPath)
            ) {
                Storage::disk('public')->delete($photoPath);
            }

            report($exception);

            return back()
                ->withInput(
                    $request->except([
                        'password',
                        'password_confirmation',
                        'foto',
                    ])
                )
                ->with(
                    'error',
                    'Akun gagal ditambahkan. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Menampilkan akun yang akan diedit.
     */
    public function edit(
        Request $request,
        User $user
    ): View {
        $this->ensureAuthorized();

        $users = $this->userQuery($request)
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.user.index',
            compact('users', 'user')
        );
    }

    /**
     * Memperbarui akun administrator.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $this->ensureAuthorized();

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],
                'role' => [
                    'required',
                    Rule::in([
                        'Super Admin',
                        'Admin',
                        'Editor',
                    ]),
                ],
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                ],
                'foto' => [
                    'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ],
            $this->validationMessages()
        );

        /*
         * Mencegah admin mengubah hak akses akunnya sendiri.
         * Ini menghindari akun yang sedang digunakan kehilangan akses.
         */
        if (
            Auth::id() === $user->id &&
            $validated['role'] !== $user->role
        ) {
            return back()
                ->withInput(
                    $request->except([
                        'password',
                        'password_confirmation',
                        'foto',
                    ])
                )
                ->with(
                    'error',
                    'Hak akses akun yang sedang digunakan tidak dapat diubah.'
                );
        }

        /*
         * Super Admin terakhir tidak boleh diturunkan perannya.
         */
        if (
            $user->role === 'Super Admin' &&
            $validated['role'] !== 'Super Admin' &&
            User::query()
                ->where('role', 'Super Admin')
                ->count() <= 1
        ) {
            return back()
                ->withInput(
                    $request->except([
                        'password',
                        'password_confirmation',
                        'foto',
                    ])
                )
                ->with(
                    'error',
                    'Super Admin terakhir tidak dapat diturunkan hak aksesnya.'
                );
        }

        $oldPhotoPath = $user->foto;
        $newPhotoPath = null;

        try {
            if ($request->hasFile('foto')) {
                $photo = $request->file('foto');

                if (!$photo || !$photo->isValid()) {
                    throw new \RuntimeException(
                        'Foto profil pengganti tidak valid.'
                    );
                }

                $newPhotoPath = $photo->store(
                    'users',
                    'public'
                );

                if (!$newPhotoPath) {
                    throw new \RuntimeException(
                        'Foto profil pengganti gagal disimpan.'
                    );
                }
            }

            DB::transaction(function () use (
                $user,
                $validated,
                $newPhotoPath
            ): void {
                $user->name = trim(
                    $validated['name']
                );

                $user->email = strtolower(
                    trim($validated['email'])
                );

                $user->role = $validated['role'];

                if (filled($validated['password'] ?? null)) {
                    $user->password = Hash::make(
                        $validated['password']
                    );
                }

                if ($newPhotoPath) {
                    $user->foto = $newPhotoPath;
                }

                $user->save();
            });

            if (
                $newPhotoPath &&
                $oldPhotoPath &&
                $oldPhotoPath !== $newPhotoPath &&
                Storage::disk('public')->exists(
                    $oldPhotoPath
                )
            ) {
                Storage::disk('public')->delete(
                    $oldPhotoPath
                );
            }

            return redirect()
                ->route('admin.users')
                ->with(
                    'success',
                    'Akun administrator berhasil diperbarui.'
                );
        } catch (Throwable $exception) {
            if (
                $newPhotoPath &&
                Storage::disk('public')->exists(
                    $newPhotoPath
                )
            ) {
                Storage::disk('public')->delete(
                    $newPhotoPath
                );
            }

            report($exception);

            return back()
                ->withInput(
                    $request->except([
                        'password',
                        'password_confirmation',
                        'foto',
                    ])
                )
                ->with(
                    'error',
                    'Akun gagal diperbarui. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Menghapus akun administrator.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->ensureAuthorized();

        if (Auth::id() === $user->id) {
            return redirect()
                ->route('admin.users')
                ->with(
                    'error',
                    'Akun yang sedang digunakan tidak dapat dihapus.'
                );
        }

        if (
            $user->role === 'Super Admin' &&
            User::query()
                ->where('role', 'Super Admin')
                ->count() <= 1
        ) {
            return redirect()
                ->route('admin.users')
                ->with(
                    'error',
                    'Super Admin terakhir tidak dapat dihapus.'
                );
        }

        $photoPath = $user->foto;

        try {
            DB::transaction(function () use ($user): void {
                $user->delete();
            });

            if (
                $photoPath &&
                Storage::disk('public')->exists($photoPath)
            ) {
                Storage::disk('public')->delete(
                    $photoPath
                );
            }

            return redirect()
                ->route('admin.users')
                ->with(
                    'success',
                    'Akun administrator berhasil dihapus.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.users')
                ->with(
                    'error',
                    'Akun gagal dihapus. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Query daftar pengguna berdasarkan filter.
     */
    private function userQuery(Request $request)
    {
        $query = User::query()
            ->orderByRaw(
                "CASE
                    WHEN role = 'Super Admin' THEN 1
                    WHEN role = 'Admin' THEN 2
                    ELSE 3
                 END"
            )
            ->latest('created_at');

        if ($request->filled('search')) {
            $search = trim(
                (string) $request->input('search')
            );

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        if ($request->filled('role')) {
            $query->where(
                'role',
                $request->input('role')
            );
        }

        return $query;
    }

    /**
     * Hanya Super Admin yang dapat mengelola akun.
     */
    private function ensureAuthorized(): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->role === 'Super Admin',
            403,
            'Hanya Super Admin yang dapat mengelola akun.'
        );
    }

    private function validationMessages(): array
    {
        return [
            'name.required' =>
                'Nama lengkap wajib diisi.',
            'name.max' =>
                'Nama lengkap maksimal 255 karakter.',

            'email.required' =>
                'Alamat email wajib diisi.',
            'email.email' =>
                'Format alamat email tidak valid.',
            'email.unique' =>
                'Alamat email sudah digunakan.',

            'role.required' =>
                'Hak akses wajib dipilih.',
            'role.in' =>
                'Hak akses yang dipilih tidak valid.',

            'password.required' =>
                'Password wajib diisi.',
            'password.min' =>
                'Password minimal 8 karakter.',
            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',

            'foto.file' =>
                'Foto profil harus berupa file.',
            'foto.image' =>
                'File foto profil harus berupa gambar.',
            'foto.mimes' =>
                'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' =>
                'Ukuran foto maksimal 5 MB.',
            'foto.uploaded' =>
                'Foto gagal diunggah. Pastikan ukurannya maksimal 5 MB.',
        ];
    }
}
