<style>
    /* MODAL STYLING */
    .modal-content {
        border-radius: 25px;
        border: none;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(10px);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 25px 30px;
        position: relative;
        overflow: hidden;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: 0.3s;
        position: relative;
        z-index: 1;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 40px 30px;
        background: rgba(255, 255, 255, 0.5);
    }

    .modal-footer {
        border: none;
        padding: 20px 30px 30px;
        background: rgba(255, 255, 255, 0.5);
    }

    /* FORM INPUTS */
    .form-control-modern {
        border: 2px solid rgba(102, 126, 234, 0.2);
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-2px);
    }

    .form-control-modern::placeholder {
        color: #999;
        font-weight: 400;
    }

    /* INPUT ICONS */
    .input-group-modern {
        position: relative;
        margin-bottom: 20px;
    }

    .input-group-modern i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        z-index: 10;
        font-size: 1.1rem;
    }

    .input-group-modern .form-control-modern {
        padding-left: 50px;
    }

    /* BUTTONS */
    .btn-login-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-login-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-registo-submit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        color: white;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(245, 87, 108, 0.4);
    }

    .btn-registo-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(245, 87, 108, 0.6);
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    }

    /* MODAL BACKDROP */
    .modal-backdrop.show {
        backdrop-filter: blur(5px);
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* ANIMATION */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.1); opacity: 0.5; }
    }
</style>

<!-- MODAL LOGIN -->
<div class="modal fade" id="modalLogin">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="processar_login.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar na Conta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group-modern">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nome_utilizador" class="form-control form-control-modern" placeholder="Nome de utilizador" required>
                    </div>
                    <div class="input-group-modern">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="palavra_passe" class="form-control form-control-modern" placeholder="Palavra-passe" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-login-submit w-100" type="submit">
                        <i class="fas fa-arrow-right me-2"></i>Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL REGISTO -->
<div class="modal fade" id="modalRegisto">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="processar_registo.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Criar Nova Conta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group-modern">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nome_utilizador" class="form-control form-control-modern" placeholder="Nome de utilizador" required>
                    </div>
                    <div class="input-group-modern">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control form-control-modern" placeholder="Email (opcional)">
                    </div>
                    <div class="input-group-modern">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="palavra_passe" class="form-control form-control-modern" placeholder="Palavra-passe" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-registo-submit w-100" type="submit">
                        <i class="fas fa-check me-2"></i>Criar Conta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>