@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

<div class="bg-dark vh-100 d-flex flex-column">

{{-- NAVBAR --}}


{{-- MAIN CONTENT --}}
<div class="container-fluid flex-grow-1 mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card theme-card bg-dark-subtle border-secondary text-white">
                <div class="card-header theme-card-header bg-secondary text-white">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-cogs me-2 mr-2"></i>General Settings</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item theme-list-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Theme Mode</h6>
                                <small class="theme-text-muted text-muted">Switch between light and dark theme.</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="theme-switch" checked>
                                <label class="form-check-label" for="theme-switch" id="theme-label">Dark Mode</label>
                            </div>
                        </li>
                        <li class="list-group-item theme-list-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Email Notifications</h6>
                                <small class="theme-text-muted text-muted">Receive alerts and summaries via email.</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="email-switch">
                            </div>
                        </li>
                         <li class="list-group-item theme-list-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Default Layout</h6>
                                <small class="theme-text-muted text-muted">Set the default grid view for live monitoring.</small>
                            </div>
                            <div>
                                <select class="form-select form-select-sm theme-form-select bg-dark text-white border-secondary" style="width: 120px;">
                                    <option value="4">2x2 Grid</option>
                                    <option value="1">1x1 Grid</option>
                                    <option value="9">3x3 Grid</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer theme-card-footer bg-secondary text-end">
                    <button class="btn btn-primary fw-semibold"><i class="fas fa-save me-2"></i>Save All Settings</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<style>
    :root {
        --primary-color: #0d6efd;
    }
    
    .main-container, .nav-item, .card, .list-group-item, .form-check-input {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .bg-dark-subtle { background-color: #2c3034; }
    .border-secondary { border-color: #495057 !important; }
    
    .nav-item.active { background-color: rgba(13, 110, 253, 0.15); }
    .active-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeSwitch = document.getElementById('theme-switch');
    const themeLabel = document.getElementById('theme-label');

    // Object containing class mappings for themes
    const themeClasses = {
        dark: {
            'bg-light': 'bg-dark',
            'bg-white': 'bg-dark-subtle',
            'border-dark-subtle': 'border-secondary',
            'text-dark': 'text-white',
            'text-black-50': 'text-muted',
            'btn-outline-dark': 'btn-outline-light'
        },
        light: {
            'bg-dark': 'bg-light',
            'bg-dark-subtle': 'bg-white',
            'bg-secondary': 'bg-white',
            'border-secondary': 'border-dark-subtle',
            'text-white': 'text-dark',
            'text-muted': 'text-black-50',
            'btn-outline-light': 'btn-outline-dark'
        }
    };

    /**
     * Applies the selected theme by swapping CSS classes.
     * @param {string} theme - The theme to apply ('dark' or 'light').
     */
    function applyTheme(theme) {
        // Get all elements to be themed
        const elementsToTheme = {
            mainContainer: document.querySelector('.main-container'),
            cards: document.querySelectorAll('.theme-card'),
            cardHeaders: document.querySelectorAll('.theme-card-header'),
            cardFooters: document.querySelectorAll('.theme-card-footer'),
            listItems: document.querySelectorAll('.theme-list-item'),
            textMuted: document.querySelectorAll('.theme-text-muted'),
            formSelects: document.querySelectorAll('.theme-form-select'),
            navItems: document.querySelectorAll('.nav-item .text-muted, .nav-item .text-white'),
            navIcons: document.querySelectorAll('.nav-item .text-muted i, .nav-item .text-primary i')
        };
        
        const currentClasses = theme === 'dark' ? themeClasses.light : themeClasses.dark;
        const newClasses = theme === 'dark' ? themeClasses.dark : themeClasses.light;

        // Function to replace classes on a set of elements
        const replaceClasses = (elements, oldClass, newClass) => {
            elements.forEach(el => {
                if(el.classList.contains(oldClass)) {
                    el.classList.replace(oldClass, newClass);
                }
            });
        };
        
        // Swap classes for all defined element types
        if(elementsToTheme.mainContainer) elementsToTheme.mainContainer.classList.replace(currentClasses['bg-dark'], newClasses['bg-dark']);
        
        elementsToTheme.cards.forEach(el => el.classList.replace(currentClasses['bg-white'], newClasses['bg-white']));
        elementsToTheme.cardHeaders.forEach(el => {
            el.classList.replace(currentClasses['bg-secondary'], newClasses['bg-secondary']);
            el.classList.replace(currentClasses['text-white'], newClasses['text-white']);
        });
        elementsToTheme.cardFooters.forEach(el => el.classList.replace(currentClasses['bg-secondary'], newClasses['bg-secondary']));

        elementsToTheme.listItems.forEach(el => {
            el.classList.replace(currentClasses['text-white'], newClasses['text-white']);
            el.style.backgroundColor = 'transparent'; // Ensure bg is transparent
        });
        elementsToTheme.textMuted.forEach(el => el.classList.replace(currentClasses['text-muted'], newClasses['text-muted']));

        elementsToTheme.formSelects.forEach(el => {
            el.classList.replace(currentClasses['bg-dark'], newClasses['bg-dark']);
            el.classList.replace(currentClasses['text-white'], newClasses['text-white']);
            el.classList.replace(currentClasses['border-secondary'], newClasses['border-secondary']);
        });

        // Update theme switch state and label
        if (themeSwitch) {
            themeSwitch.checked = theme === 'dark';
            themeLabel.textContent = theme === 'dark' ? 'Dark Mode' : 'Light Mode';
        }
        
        // Save the theme to localStorage
        localStorage.setItem('theme', theme);
    }

    // Event listener for the theme switch
    if (themeSwitch) {
        themeSwitch.addEventListener('change', function() {
            const newTheme = this.checked ? 'dark' : 'light';
            applyTheme(newTheme);
        });
    }

    // On initial page load, apply the saved theme or default to dark
    const savedTheme = localStorage.getItem('theme') || 'dark';
    applyTheme(savedTheme);
});
</script>
@endpush