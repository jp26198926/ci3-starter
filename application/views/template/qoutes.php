<div class="carousel slide" data-ride="carousel" id="quote-carousel">
  <!-- Bottom Carousel Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#quote-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#quote-carousel" data-slide-to="1"></li>
    <li data-target="#quote-carousel" data-slide-to="2"></li>
  </ol>

  <!-- Carousel Slides / Quotes -->
  <div class="carousel-inner">

    <!-- Quote 1 -->
    <div class="item active">
      <blockquote>
        <div class="row">
          <div class="col-sm-3 text-center">
            <img class="img-circle" src="<?= base_url(); ?>assets/images/1.gif" style="width: 100px;height:100px;">
            <!--<img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/128.jpg" style="width: 100px;height:100px;">-->
          </div>
          <div class="col-sm-9">
            <p class='quotes_msg1'>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
            <small class='quotes_author1'>Someone famous</small>
          </div>
        </div>
      </blockquote>
    </div>
    <!-- Quote 2 -->
    <div class="item">
      <blockquote>
        <div class="row">
          <div class="col-sm-3 text-center">
            <img class="img-circle" src="<?= base_url(); ?>assets/images/2.gif" style="width: 100px;height:100px;">
          </div>
          <div class="col-sm-9">
            <p class='quotes_msg2'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor nec lacus ut tempor. Mauris.</p>
            <small class='quotes_author2'>Someone famous</small>
          </div>
        </div>
      </blockquote>
    </div>
    <!-- Quote 3 -->
    <div class="item">
      <blockquote>
        <div class="row">
          <div class="col-sm-3 text-center">
            <img class="img-circle" src="<?= base_url(); ?>assets/images/3.gif" style="width: 100px;height:100px;">
          </div>
          <div class="col-sm-9">
            <p class='quotes_msg3'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum elit in arcu blandit, eget pretium nisl accumsan. Sed ultricies commodo tortor, eu pretium mauris.</p>
            <small class='quotes_author3'>Someone famous</small>
          </div>
        </div>
      </blockquote>
    </div>
  </div>

  <!-- Carousel Buttons Next/Prev -->
  <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
  <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
</div>