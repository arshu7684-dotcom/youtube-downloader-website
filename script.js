document.addEventListener('DOMContentLoaded', function() {
    const downloadForm = document.getElementById('downloadForm');
    const videoUrlInput = document.getElementById('videoUrl');
    const downloadBtn = document.getElementById('downloadBtn');
    const btnText = downloadBtn.querySelector('.btn-text');
    const btnLoader = downloadBtn.querySelector('.btn-loader');

    function isValidYouTubeUrl(url) {
        const patterns = [
            /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/,
            /^(https?:\/\/)?(www\.)?(youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
            /^(https?:\/\/)?(www\.)?(youtube\.com\/v\/)([a-zA-Z0-9_-]{11})/
        ];
        return patterns.some(pattern => pattern.test(url));
    }

    videoUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        if (url && !isValidYouTubeUrl(url)) {
            this.style.borderColor = '#e53e3e';
        } else {
            this.style.borderColor = '#e2e8f0';
        }
    });

    downloadForm.addEventListener('submit', function(e) {
        const url = videoUrlInput.value.trim();
        
        if (!url) {
            e.preventDefault();
            showError('Please enter a YouTube URL');
            return;
        }
        
        if (!isValidYouTubeUrl(url)) {
            e.preventDefault();
            showError('Please enter a valid YouTube URL');
            return;
        }

        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';
        downloadBtn.disabled = true;
        
        addToRecentSearches(url);
    });

    function showError(message) {
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.cssText = `
            color: #e53e3e;
            background: #fed7d7;
            padding: 12px 20px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #e53e3e;
        `;
        errorDiv.textContent = message;

        downloadForm.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    function addToRecentSearches(url) {
        let recentSearches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
        
        if (!recentSearches.includes(url)) {
            recentSearches.unshift(url);
            recentSearches = recentSearches.slice(0, 5);
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
        }
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.feature-card, .step, .faq-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
