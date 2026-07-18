<script>
(function(){
  const modal = document.getElementById('public-lightbox');
  if(!modal) return;

  // If gallery modal exists but no matching elements yet, avoid errors.
  const overlayImgs = document.querySelectorAll('.public-lightbox');
  if(!overlayImgs || overlayImgs.length === 0) return;


  const img = document.getElementById('public-lightbox-img');
  const title = document.getElementById('public-lightbox-title');
  const closeBtn = modal.querySelector('.public-lightbox-close');

  function openLightbox(src, t){
    if(img) img.src = src;
    if(title) title.textContent = t || '';
    modal.setAttribute('aria-hidden','false');
    modal.classList.add('open');
  }

  function closeLightbox(){
    modal.setAttribute('aria-hidden','true');
    modal.classList.remove('open');
    if(img) img.src = '';
    if(title) title.textContent = '';
  }

  document.querySelectorAll('.public-lightbox').forEach(a=>{
    a.addEventListener('click', function(e){
      e.preventDefault();
      openLightbox(this.getAttribute('href'), this.getAttribute('data-title'));
    });
  });

  if(closeBtn){
    closeBtn.addEventListener('click', closeLightbox);
  }

  modal.addEventListener('click', function(e){
    if(e.target === modal) closeLightbox();
  });

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') closeLightbox();
  });
})();
</script>

