<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Administrar Usuarios</h3>
        <div class="button-group">
            <a href="<?= base_url('anadir_admin') ?>" class="btn btn-primary">Añadir Administrador</a>
            <a href="<?= base_url('ver_usuarios') ?>" class="btn btn-primary">Lista de Usuarios</a>
        </div>
    </div>
</div>

<style>
.button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
}
.btn-primary:hover {
    background-color: #0056b3;
}
</style>