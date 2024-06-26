<?php

namespace myapp\controllers;

use myapp\database\Database;
use myapp\helpers\ExportCSV;
use myapp\models\Bandoc;
use myapp\models\Sach;
use myapp\models\Vipham;
use myapp\Router;

class ThongKeController
{
  public static function index(Router $router)
  {
    $data = [];

    $data["SACHCHUATRA"] = Database::query("SELECT themuontra.MATHEMUON, sach.MASACH, sach.TENSACH,themuontra.NGAYMUON, themuontra.NGAYTRA, bandoc.HOTEN, bandoc.MABANDOC, admin.USERNAME FROM themuontra INNER JOIN sach_themuontra ON themuontra.MATHEMUON = sach_themuontra.MATHEMUON INNER JOIN sach ON sach.MASACH = sach_themuontra.MASACH INNER JOIN bandoc ON bandoc.MABANDOC = themuontra.MABANDOC INNER JOIN admin ON admin.MAADMIN = themuontra.MAADMIN WHERE themuontra.TINHTRANG = 'Chưa trả'");
    $data["SACHCHUATRA_ROWS"] = $data["SACHCHUATRA"]->num_rows;

    $data["SACHQUAHAN"] = Database::query("SELECT themuontra.MATHEMUON, sach.MASACH, sach.TENSACH,themuontra.NGAYMUON, themuontra.NGAYTRA, bandoc.HOTEN, bandoc.MABANDOC, admin.USERNAME FROM themuontra INNER JOIN sach_themuontra ON themuontra.MATHEMUON = sach_themuontra.MATHEMUON INNER JOIN sach ON sach.MASACH = sach_themuontra.MASACH INNER JOIN bandoc ON bandoc.MABANDOC = themuontra.MABANDOC INNER JOIN admin ON admin.MAADMIN = themuontra.MAADMIN WHERE themuontra.TINHTRANG = 'Quá hạn'");
    $data["SACHQUAHAN_ROWS"] = $data["SACHQUAHAN"]->num_rows;

    $data["BANDOCTHANGNAY"] = Database::query("SELECT * FROM bandoc WHERE NGAYTHEM >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH AND NGAYTHEM <  LAST_DAY(CURDATE()) + INTERVAL 1 DAY");
    $data["BANDOCTHANGNAY_ROWS"] = $data["BANDOCTHANGNAY"]->num_rows;

    $data["SACHTHANGNAY"] = Database::query("SELECT sach.MASACH, sach.MATHELOAI, sach.MATACGIA, sach.`TENSACH`, sach.`SOLUONG`, sach.`VITRI`, sach.`TOMTAT`, sach.`ANHSACH`, sach.`NGAYTHEM`, sach.`NGAYCAPNHAT`, tacgia.`BUTDANH`, theloai.`TEN`, tacgia.MATACGIA, theloai.MATHELOAI FROM `sach` INNER JOIN tacgia on sach.MATACGIA = tacgia.MATACGIA INNER JOIN theloai on sach.MATHELOAI = theloai.MATHELOAI WHERE sach.NGAYTHEM >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH AND sach.NGAYTHEM <  LAST_DAY(CURDATE()) + INTERVAL 1 DAY");
    $data["SACHTHANGNAY_ROWS"] = $data["SACHTHANGNAY"]->num_rows;

    $data["VPTHANGNAY"] = Database::query("SELECT vipham.MAVIPHAM, vipham.NOIDUNG, vipham.NGAYTHEM, bandoc.HOTEN, bandoc.MABANDOC, admin.USERNAME FROM vipham INNER JOIN bandoc ON vipham.MABANDOC = bandoc.MABANDOC INNER JOIN admin ON admin.MAADMIN = vipham.MAADMIN WHERE vipham.NGAYTHEM >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH AND vipham.NGAYTHEM <  LAST_DAY(CURDATE()) + INTERVAL 1 DAY");
    $data["VPTHANGNAY_ROWS"] = $data["VPTHANGNAY"]->num_rows;

    $router->renderAdminPanel('admin/analytics/trangchu', [
      'data' => $data
    ]);
  }

  public static function download()
  {
    $flag = $_GET["target"] ?? "";

    if ($flag && $_SESSION["auth"]) {
      $exportCSV = new ExportCSV();
      switch ($flag) {
        case "chuatra":
          $data = Sach::getBorrowedBooks();
          $exportCSV->export($data, "SachChuaTra");
          break;
        case "quahan":
          $data = Sach::getExpiredBooks();
          $exportCSV->export($data, "SachQuaHan");
          break;
        case "sach":
          $data = Sach::getThisMonth();
          $exportCSV->export($data, "SachMoiThangNay");
          break;
        case "bandoc":
          $data = Bandoc::getThisMonth();
          $exportCSV->export($data, "BanDocThangNay");
          break;
        case "vipham":
          $data = Vipham::getThisMonth();
          $exportCSV->export($data, "ViPhamThangNay");
          break;
        case "all":
          $exportCSV->exportMany([
            "Sách chưa trả" => Sach::getBorrowedBooks(),
            "Sách quá hạn" => Sach::getExpiredBooks(),
            "Sách mới tháng này" => Sach::getThisMonth(),
            "Bạn đọc mới tháng này" => Bandoc::getThisMonth(),
            "Vi phạm mới tháng này" => ViPham::getThisMonth()
          ]);
          break;
        default:
          header("Content-type: application/json");
          echo json_encode([
            "message" => "Lựa chọn không tồn tại!"
          ]);
          break;
      }
    } else {
      header("Content-type: application/json");
      echo json_encode([
        "message" => "Quyền truy cập bị từ chối!"
      ]);
    }
  }
}
