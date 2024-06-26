<?php $headTitle = "Thư viện trường Đại học Công nghệ Đông Á"; ?>

<?php if ($search["name"]) : ?>
  <h3 style="width: max-content; margin: 24px auto;">Kết quả tìm kiếm cho "<?php echo $search["name"] ?>"</h3>
<?php endif; ?>
<div class="uk-grid-small uk-child-width-1-6@xl uk-child-width-1-5@l uk-child-width-1-3@m uk-child-width-1-2@s uk-padding-small" uk-grid>
  <?php foreach ($books as $book) : ?>
    <div id="<?php echo $book["TENSACH"] . "_" . $book["MASACH"] ?>">
      <div class="uk-card uk-card-default uk-height-large uk-overflow-hidden">
        <div class="uk-card-media-top uk-height-medium" style="width: 100%; aspect-ratio: 1 / 2; background-position: center; background-image: url(<?php echo $book["ANHSACH"] ?>); background-size: cover;">
        </div>
        <div class="uk-padding-small">
          <h3 class="uk-card-title uk-link-heading">
            <a href="/books?id=<?php echo $book["MASACH"] ?>">
              <?php echo $book["TENSACH"] ?>
            </a>
          </h3>

          <section>
            <a href="/?author=<?php echo urlencode($book["MATACGIA"]) ?>">
              <?php echo $book["BUTDANH"] ?>
            </a>
            -
            <a href="/?genre=<?php echo urlencode($book["MATHELOAI"]) ?>">
              <?php echo $book["TEN"] ?>
            </a>
          </section>

          <p class="uk-text-meta uk-text-truncate"><?php echo $book["TOMTAT"] ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>