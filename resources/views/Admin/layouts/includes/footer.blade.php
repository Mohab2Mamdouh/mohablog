<!-- Modern Footer -->
<footer class="modern-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Mohablog</h3>
                <p>Dashboard Management System</p>
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
    padding: 40px 0 25px;
    margin-top: 60px;
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
    gap: 20px;
    text-align: center;
}

.footer-brand h3 {
    color: #fff;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.footer-brand p {
    color: #64748b;
    font-size: 0.9rem;
}

.footer-copyright {
    color: #64748b;
    font-size: 0.85rem;
    padding-top: 15px;
    border-top: 1px solid rgba(148,163,184,0.1);
    width: 100%;
    text-align: center;
}
</style>
