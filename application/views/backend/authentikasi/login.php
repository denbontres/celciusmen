<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <h4 class="text-center mb-3">LOGIN</h4>

      <form action="<?=base_url('admin/Authentikasi')?>" method="post">
        <div class="form-group">
          <?= $this->session->flashdata('pesan')?>
        </div>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Email" name="email" value="<?=set_value('email')?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <?= form_error('email','<small class="text-danger pl-3">','</small>');?>
        <div class="input-group mt-2">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <?= form_error('password','<small class="text-danger pl-3">','</small>');?>
        <div class="social-auth-links text-center mt-2">
          <button type="submit" class="btn btn-block btn-primary">Login</button>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->