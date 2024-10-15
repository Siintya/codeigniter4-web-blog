<?= $this->extend('layouts/page') ?>
<?= $this->section('title'); ?>
<?= $page['title'] ;?>
<?=$this->endSection(); ?>
<?= $this->section('content'); ?>
    <?= $this->include('templates/navbar') ?>
	<!-- Header -->
	<div class="site-cover site-cover-sm same-height overlay single-page">
		<div class="container">
			<div class="row same-height justify-content-between">
				<div class="col-md-12">
					<div class="post-entry">
						<h1><?= $page['title'] ;?></h1>
					</div>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a class="text-dark" href="/">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= $page['title'] ;?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<section class="section page py-5">
		<div class="container-fluid py-0">
			<div class="container">
				<?php if ($slug == 'about-us') : ?>
					<?php if (!empty($contents)) : ?>
						<?php foreach ($contents as $content) :?>
							<div class="element-animate">
								<div class="main-content">
									<?php if ($content['contents_image']) : ?>
										<img src="data:image/jpeg;base64,<?= base64_encode($content['contents_image']) ?>" alt="" class="img-fluid rounded post-content-img">
									<?php endif; ?>
									<div class="post-content-body mt-4" id="<?= $content['contents_slug'] ?>">
										<h2 class="heading mb-3"><?= $content['contents_title'] ;?></h2>
										<div class="mb-5"><?= $content['contents_content'] ?></div>
									</div>
								</div>
							</div>
						<?php endforeach ;?>
					<?php endif ;?>
					<?php elseif ($slug == 'blog') :?>
						<div class="row posts-entry">
							<div class="col-lg-8">
								<?php foreach($articles as $article) : ?>
									<div class="blog-entry d-flex blog-entry-search-item row">
										<div class="col-md-4">
											<a href="#" class="img-link me-4">
												<?php if ($article['image']) : ?>
													<img src="data:image/jpeg;base64,<?= base64_encode($article['image']) ?>" alt="Image" class="img-fluid">
												<?php endif ;?>	
											</a>
										</div>
										<div class="col-md-8">
											<span class="date"><?= date('F d, Y ', strtotime($article['created_at'])); ?> &bullet; <?= $article['username'] ;?> </span> 
											<h2><a href="#"><?=$article['title'] ;?></a></h2>
											<p><?= word_limiter($article['content'], 40); ?></p>
											<p><a href="#" class="btn btn-md mt-3 btn-outline-dark">Read More</a></p>
										</div>
									</div>
								<?php endforeach ;?>
							</div>

							<div class="col-lg-4 sidebar">

								<div class="sidebar-box search-form-wrap mb-4">
									<form action="#" class="sidebar-search-form">
									<span class="bi-search"></span>
									<input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
									</form>
								</div>
								<!-- END sidebar-box -->
								<div class="sidebar-box">
									<h3 class="heading">Popular Posts</h3>
									<div class="post-entry-sidebar">
									<ul>
										<li>
										<a href="">
											<img src="images/img_1_sq.jpg" alt="Image placeholder" class="me-4 rounded">
											<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
											</div>
										</a>
										</li>
										<li>
										<a href="">
											<img src="images/img_2_sq.jpg" alt="Image placeholder" class="me-4 rounded">
											<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
											</div>
										</a>
										</li>
										<li>
										<a href="">
											<img src="images/img_3_sq.jpg" alt="Image placeholder" class="me-4 rounded">
											<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
											</div>
										</a>
										</li>
									</ul>
									</div>
								</div>
								<!-- END sidebar-box -->

								<div class="sidebar-box">
									<h3 class="heading">Categories</h3>
									<ul class="categories">
									<li><a href="#">Food <span>(12)</span></a></li>
									<li><a href="#">Travel <span>(22)</span></a></li>
									<li><a href="#">Lifestyle <span>(37)</span></a></li>
									<li><a href="#">Business <span>(42)</span></a></li>
									<li><a href="#">Adventure <span>(14)</span></a></li>
									</ul>
								</div>
								<!-- END sidebar-box -->

								<div class="sidebar-box">
									<h3 class="heading">Tags</h3>
									<ul class="tags">
									<li><a href="#">Travel</a></li>
									<li><a href="#">Adventure</a></li>
									<li><a href="#">Food</a></li>
									<li><a href="#">Lifestyle</a></li>
									<li><a href="#">Business</a></li>
									<li><a href="#">Freelancing</a></li>
									<li><a href="#">Travel</a></li>
									<li><a href="#">Adventure</a></li>
									<li><a href="#">Food</a></li>
									<li><a href="#">Lifestyle</a></li>
									<li><a href="#">Business</a></li>
									<li><a href="#">Freelancing</a></li>
									</ul>
								</div>

							</div>
						</div>
					<?php elseif ($slug == 'contact-us') : ?>
						<div class="row">
							<div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
								<div class="contact-info">
								<?php foreach ($contents as $content) :?>
									<?php if ($content['contents_title'] == 'Address') : ?>
										<div class="address mt-2">
											<i class="bi bi-geo-fill"></i>
											<h4 class="mb-2">Location:</h4>
											<p><?= $content['contents_content'] ;?></p>
										</div>
									<?php elseif ($content['contents_title'] == 'Email') : ?>
										<div class="email mt-4">
											<i class="bi bi-envelope-fill"></i>
											<h4 class="mb-2">Email:</h4>
											<p><?= $content['contents_content'] ;?></p>
										</div>
									<?php elseif ($content['contents_title'] == 'Phone number') : ?>
										<div class="phone mt-4">
											<i class="bi bi-telephone-fill"></i>
											<h4 class="mb-2">Phone number:</h4>
											<p><?= $content['contents_content'] ;?></p>
										</div>
									<?php endif; ?>
								<?php endforeach ;?>
								</div>
							</div>
							<div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
								<form action="#" class="form" role="form">
									<div class="row">
										<div class="col-6 mb-3">
											<input type="text" class="form-control" placeholder="Your Name">
										</div>
										<div class="col-6 mb-3">
											<input type="email" class="form-control" placeholder="Your Email">
										</div>
										<div class="col-12 mb-3">
											<input type="text" class="form-control" placeholder="Subject">
										</div>
										<div class="col-12 mb-3">
											<textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
										</div>

										<div class="col-12">
											<input type="submit" value="Send Message" class="btn btn-dark">
										</div>
									</div>
								</form>
							</div>
						</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?= $this->include('templates/footer') ?>
<?= $this->endSection(); ?>

