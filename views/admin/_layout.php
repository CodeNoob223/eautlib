<?php
if (!$_SESSION["auth"]) {
  header("location: /");
}
$roles = [
  "QUAN_TRI" => "Quản trị viên",
  "THU_THU" => "Thủ thư"
];
?>
<!DOCTYPE html>
<html>

<?php include_once "../includes/head.php" ?>

<body>
  <?php if (!empty($errors)) : ?>
    <script type="text/javascript">
      let errors = <?php echo json_encode($errors); ?>;
      errors.forEach(msg => {
        UIkit.notification({
          message: "<span uk-icon='icon: ban'></span> " + msg,
          status: 'danger',
          pos: 'top-center',
          timeout: 5000
        });
      })
    </script>
  <?php endif; ?>
  <?php if (isset($_SESSION["auth"])) : ?>
    <div class="uk-section uk-section-secondary uk-padding-small noPrint">
      <p class="uk-align-center uk-text-primary uk-text-center">
        User: <?php echo $_SESSION["username"] ?>. Vai trò: <?php echo $roles[$_SESSION["role"]] ?>
      </p>
    </div>
  <?php endif; ?>

  <div class="uk-container uk-container-expand uk-section-primary uk-box-shadow-medium">
    <nav class="uk-navbar" uk-navbar style="align-items: center;">

      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo uk-text-bold uk-visible@l" href="/" aria-label="Back to Home">
          <img src="/public/eaut_logo.png" class="uk-margin-tiny-right uk-border-circle" width="60" height="60" alt="UIkit">
          EAUT Library
        </a>
        <a class="uk-navbar-item uk-logo uk-text-bold uk-hidden@l" style="font-size: 20px !important;" href="/" aria-label="Back to Home">
          <img src="/public/eaut_logo.png" class="uk-margin-tiny-right uk-border-circle" width="40" height="40" alt="UIkit">
          EAUT Library
        </a>
      </div>

      <div class="uk-navbar-right">
        <?php if (isset($_SESSION["auth"])) : ?>
          <a class="uk-button uk-button-default uk-visible@l" href="/auth/logout">Đăng xuất</a>
        <?php else : ?>
          <a class="uk-button uk-button-default uk-visible@l" href="/auth/login">Đăng nhập</a>
        <?php endif; ?>

        <button class="uk-button uk-text-primary uk-text-bold uk-hidden@l uk-padding-remove noPrint" type="button" uk-toggle="target: #offcanvas-overlay" uk-icon="icon: menu; ratio: 1.2"></button>

        <!-- SIDEBAR -->
        <div class="uk-hidden@l" id="offcanvas-overlay" uk-offcanvas="overlay: true; flip: true">
          <div class="uk-offcanvas-bar uk-background-primary">

            <button class="uk-offcanvas-close uk-padding uk-text-primary" type="button" uk-close></button>

            <?php if (isset($_SESSION["auth"])) : ?>
              <a class="uk-button uk-button-default" href="/auth/logout">Đăng xuất</a>
            <?php else : ?>
              <a class="uk-button uk-button-default" href="/auth/login">Đăng nhập</a>
            <?php endif; ?>

            <hr>

            <ul class="uk-list uk-list-divider">
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: album"></span><a id="sach-link-sidebar" href="/admin/books/">Sách</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: code"></span><a id="theloai-link-sidebar" href="/admin/genres/">Thể loại</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: users"></span><a id="tacgia-link-sidebar" href="/admin/authors/">Tác giả</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: happy"></span><a id="bandoc-link-sidebar" href="/admin/readers/">Bạn đọc</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: ban"></span><a id="vipham-link-sidebar" href="/admin/violations/">Vi phạm</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: forward"></span><a id="muontra-link-sidebar" href="/admin/borrows">Mượn trả</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: lock"></span><a id="account-link-sidebar" href="/admin/accounts">Tài khoản</a></li>
              <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: thumbnails"></span><a id="thongke-link-sidebar" href="/admin/analytics">Thống kê</a></li>
            </ul>
          </div>
        </div>
        <!-- SIDEBAR -->

      </div>
    </nav>
  </div>
  <div class="uk-flex">
    <ul class="uk-list uk-padding-small uk-margin-small-top uk-list-divider uk-text-bold uk-width-1-6@l uk-visible@l">
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: album"></span><a id="sach-link-dashboard" href="/admin/books/">Sách</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: code"></span><a id="theloai-link-dashboard" href="/admin/genres/">Thể loại</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: users"></span><a id="tacgia-link-dashboard" href="/admin/authors/">Tác giả</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: happy"></span><a id="bandoc-link-dashboard" href="/admin/readers/">Bạn đọc</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: ban"></span><a id="vipham-link-dashboard" href="/admin/violations/">Vi phạm</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: forward"></span><a id="muontra-link-dashboard" href="/admin/borrows">Mượn trả</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: lock"></span><a id="taikhoan-link-dashboard" href="/admin/accounts">Tài khoản</a></li>
      <li style="display: flex; align-items: center; gap: 6px"><span uk-icon="icon: thumbnails"></span><a id="thongke-link-dashboard" href="/admin/analytics">Thống kê</a></li>
    </ul>
    <div class="uk-padding-small uk-width-expand">
      <?php echo $content ?>
    </div>
  </div>
</body>

</html>