<!-- Modern Footer -->
<footer class="modern-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Mohablog</h3>
                <p>Building amazing web experiences</p>
            </div>
            <div class="footer-links">
                <a href="{{ route('portfolio') }}">
                    <i class="fas fa-home"></i> Portfolio
                </a>
                @if(isset($user))
                    <a href="{{ $user->github }}" target="_blank">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                    <a href="{{ $user->linked_in }}" target="_blank">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                @endif
            </div>
            <div class="footer-copyright">
                © {{ date('Y') }} Mohablog. All rights reserved.
            </div>
        </div>
    </div>
</footer>

<style>
.modern-footer {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #94a3b8;
    padding: 50px 0 30px;
    margin-top: 80px;
    position: relative;
    overflow: hidden;
}

.modern-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    text-align: center;
}

.footer-brand h3 {
    color: #fff;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 8px;
}

.footer-brand p {
    color: #64748b;
    font-size: 0.95rem;
}

.footer-links {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
}

.footer-links a:hover {
    color: #fff;
    background: rgba(99,102,241,0.2);
    transform: translateY(-3px);
}

.footer-copyright {
    color: #64748b;
    font-size: 0.9rem;
    padding-top: 20px;
    border-top: 1px solid rgba(148,163,184,0.1);
    width: 100%;
    text-align: center;
}

@media (max-width: 768px) {
    .footer-links {
        flex-direction: column;
        gap: 15px;
    }
}
</style>
