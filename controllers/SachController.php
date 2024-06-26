<?php

namespace myapp\controllers;

use myapp\models\Sach;
use myapp\models\Tacgia;
use myapp\models\Theloai;
use myapp\Router;

class SachController
{
  public static function index(Router $router)
  {
    $search = [
      'name' => trim($_GET['name'] ?? ''),
      'author' => (int)$_GET['author'] ?? '',
      'genre' => (int)$_GET['genre'] ?? ''
    ];
    $books = Sach::get($search);
    $genres = Theloai::get();
    $authors = Tacgia::get();

    $router->renderAdminPanel('admin/books/trangchu', [
      'search' => $search,
      'books' => $books,
      'genres' => $genres,
      'authors' => $authors
    ]);
  }

  public static function guestView(Router $router)
  {
    $search = [
      'name' => trim($_GET['name']) ?? '',
      'author' => $_GET['author'] ?? '',
      'genre' => $_GET['genre'] ?? ''
    ];
    $books = Sach::get($search);
    $router->renderView('books/trangchu', [
      'search' => $search,
      'books' => $books
    ]);
  }

  public static function guestRead(Router $router)
  {
    $id = $_GET['id'] ?? '';
    if (!$id) {
      header("location: /");
      exit;
    }
    $book = Sach::getById($id);
    $router->renderView('books/xem', [
      'book' => $book
    ]);
  }

  public static function create(Router $router)
  {
    $errors = [];
    $sachData = [
      'MATHELOAI' => '',
      'MATACGIA' => '',
      'SOLUONG' => '',
      'TENSACH' => '',
      'VITRI' => '',
      'TOMTAT' => '',
      'ANHSACH' => '',
      'imageFile' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $sachData['MATHELOAI'] = $_POST['MATHELOAI'];
      $sachData['MATACGIA'] = $_POST['MATACGIA'];
      $sachData['SOLUONG'] = (int)$_POST['SOLUONG'];
      $sachData['VITRI'] = trim($_POST['VITRI']);
      $sachData['TOMTAT'] = trim($_POST['TOMTAT']);
      $sachData['VITRI'] = trim($_POST['VITRI']);
      $sachData['TENSACH'] = trim($_POST['TENSACH']);

      $sach = new Sach();
      $sach->load($sachData);
      $errors = $sach->save("create");

      if (empty($errors)) {
        header("location: /admin/books");
        exit;
      }
    }
    $authors = Tacgia::get();
    $genres = Theloai::get();
    $router->renderAdminPanel('admin/books/them', [
      'book' => $sachData,
      'errors' => $errors,
      'authors' => $authors,
      'genres' => $genres
    ]);
  }

  public static function update(Router $router)
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      header('locations: /admin/books');
      exit;
    }
    $sachData = Sach::getById($id);
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $sachData['MATHELOAI'] = $_POST['MATHELOAI'];
      $sachData['MATACGIA'] = $_POST['MATACGIA'];
      $sachData['SOLUONG'] = (int)$_POST['SOLUONG'];
      $sachData['VITRI'] = trim($_POST['VITRI']);
      $sachData['TOMTAT'] = trim($_POST['TOMTAT']);
      $sachData['VITRI'] = trim($_POST['VITRI']);
      $sachData['TENSACH'] = trim($_POST['TENSACH']);

      $sach = new Sach();
      $sach->load($sachData);
      $errors = $sach->save("update");

      if (empty($errors)) {
        header("location: /admin/books");
        exit;
      }
    }
    $authors = Tacgia::get();
    $genres = Theloai::get();

    $router->renderAdminPanel('admin/books/sua', [
      'book' => $sachData,
      'errors' => $errors,
      'authors' => $authors,
      'genres' => $genres
    ]);
  }

  public static function delete(Router $router)
  {
    $id = $_POST['MASACH'] ?? null;

    if ($id) {
      $sachData = Sach::getById($id);
      Sach::delete($id, $sachData["ANHSACH"]);
    }
    header('location: /admin/books');
    exit;
  }
}
