import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.menu-toggle').forEach(menu => {

        menu.addEventListener('click', () => {

            const target = document.getElementById(menu.dataset.target);

            if(target){
                target.classList.toggle('show');
            }

            const icon = menu.querySelector('.bi-chevron-down');

            if(icon){
                icon.classList.toggle('rotate');
            }

        });

    });

    const searchContainer = document.querySelector('.search-box');
    const menuItems = searchContainer ? JSON.parse(searchContainer.dataset.searchItems) : [];

    const searchInput = document.getElementById('navbar-search');
    const searchResults = document.getElementById('navbar-search-results');
    let activeIndex = -1;

    const updateDateTime = () => {
        const now = new Date();
        const date = new Intl.DateTimeFormat('id-ID', {
            weekday:'long',
            day:'numeric',
            month:'long',
            year:'numeric'
        }).format(now);
        const time = new Intl.DateTimeFormat('id-ID', {
            hour:'2-digit',
            minute:'2-digit'
        }).format(now);
        const dateEl = document.getElementById('navbar-date');
        const timeEl = document.getElementById('navbar-time');
        if(dateEl) dateEl.textContent = date;
        if(timeEl) timeEl.textContent = time;
    };

    const renderSearchResults = items => {
        if(!searchResults) return;
        searchResults.innerHTML = '';
        if(items.length === 0){
            searchResults.classList.remove('active');
            return;
        }
        items.forEach((item, index) => {
            const li = document.createElement('li');
            li.className = 'suggestion-item';
            li.setAttribute('role', 'option');
            li.setAttribute('data-url', item.url);
            li.tabIndex = 0;
            if(index === activeIndex){
                li.classList.add('active');
            }
            li.innerHTML = `<span>${item.label}</span>`;
            li.addEventListener('click', () => {
                window.location.href = item.url;
            });
            li.addEventListener('keydown', event => {
                if(event.key === 'Enter'){
                    window.location.href = item.url;
                }
            });
            searchResults.appendChild(li);
        });
        searchResults.classList.add('active');
    };

    const closeSearch = () => {
        if(searchResults){
            searchResults.classList.remove('active');
            activeIndex = -1;
        }
    };

    if(searchInput){
        searchInput.addEventListener('input', event => {
            const query = event.target.value.trim().toLowerCase();
            if(!query){
                closeSearch();
                return;
            }
            const filtered = menuItems.filter(item => item.label.toLowerCase().includes(query));
            activeIndex = -1;
            renderSearchResults(filtered.slice(0, 8));
        });

        searchInput.addEventListener('keydown', event => {
            const items = searchResults ? Array.from(searchResults.querySelectorAll('.suggestion-item')) : [];
            if(!items.length) return;
            if(event.key === 'ArrowDown'){
                event.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                items.forEach((item, index) => item.classList.toggle('active', index === activeIndex));
            }
            if(event.key === 'ArrowUp'){
                event.preventDefault();
                activeIndex = activeIndex <= 0 ? items.length - 1 : activeIndex - 1;
                items.forEach((item, index) => item.classList.toggle('active', index === activeIndex));
            }
            if(event.key === 'Enter' && activeIndex >= 0){
                event.preventDefault();
                const url = items[activeIndex].dataset.url;
                if(url){
                    window.location.href = url;
                }
            }
            if(event.key === 'Escape'){
                closeSearch();
            }
        });
    }

    const mobileMenuToggle = document.querySelector('.public-menu-toggle');
    const mobileMenu = document.querySelector('.public-mobile-menu');
    if(mobileMenuToggle && mobileMenu){
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
            const expanded = mobileMenu.classList.contains('show');
            mobileMenuToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    }

    document.addEventListener('click', event => {
        const target = event.target;
        if(searchInput && !searchInput.contains(target) && searchResults && !searchResults.contains(target)){
            closeSearch();
        }
        if(mobileMenu && !mobileMenu.contains(target) && !event.target.closest('.public-menu-toggle')){
            mobileMenu.classList.remove('show');
            if(mobileMenuToggle){
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        }
    });

    const counterElements = document.querySelectorAll('.stat-count');
    const animateCounters = () => {
        counterElements.forEach(el => {
            const target = Number(el.dataset.target || 0);
            const duration = 1200;
            const stepTime = Math.max(Math.floor(duration / (target || 1)), 15);
            let current = 0;
            const increment = target > 0 ? Math.ceil(target / (duration / stepTime)) : 1;

            const counter = setInterval(() => {
                current += increment;
                if (current >= target) {
                    el.textContent = target.toLocaleString('id-ID');
                    clearInterval(counter);
                } else {
                    el.textContent = current.toLocaleString('id-ID');
                }
            }, stepTime);
        });
    };

    if (counterElements.length) {
        animateCounters();
    }

    const profileTrigger = document.querySelector('.js-profile-trigger');
    const profileMenu = document.querySelector('.js-profile-menu');
    const profileDropdown = document.querySelector('.js-dropdown');

    const closeProfileMenu = () => {
        if(profileDropdown){
            profileDropdown.classList.remove('open');
            if(profileTrigger){
                profileTrigger.setAttribute('aria-expanded', 'false');
            }
        }
    };

    if(profileTrigger && profileMenu && profileDropdown){
        profileTrigger.addEventListener('click', event => {
            event.preventDefault();
            profileDropdown.classList.toggle('open');
            const expanded = profileDropdown.classList.contains('open');
            profileTrigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });

        document.addEventListener('click', event => {
            if(profileDropdown && !profileDropdown.contains(event.target)){
                closeProfileMenu();
            }
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 60000);

});