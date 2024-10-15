<?= $this->extend('layouts/page') ?>

<?= $this->section('content'); ?>
    <?= $this->include('templates/navbar') ?>
	<!-- Header -->
	<section class="header">
		<div class="container align-items-center py-5">
			<div class="row g-5 d-flex flex-nowrap">
				<div class="col-md-8 header-content">
					<h1 class="header-title">Explore, Learn, and Grow with Us</h1>
                	<p class="header-text">
					Discover insightful articles, tips, and stories that inspire and inform. Whether you're looking for the latest trends, expert advice, or personal reflections, our blog has something for everyone. Join our community and start your journey with us today!
					</p>
				</div>
				<div class="col-md-4 header-img-container">
					<div class="header-img">
						<img src="<?= base_url('assets') ?>/images/bg-header.jpeg" alt="" class="img-fluid rounded bw-filter">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="about py-5">
		<div class="container section sec-halfs py-0">
			<div class="container">
				<div class="row mb-4">
					<div class="col-sm-12">
						<h2 class="text-center posts-entry-title">About Us</h2>
					</div>
				</div>
				<?php if (!empty($about)) : ?>
					<?php foreach ($about as $index => $a) :?>
						<div class="half-content d-lg-flex align-items-stretch">
							<?php if ($a['contents_image']) : ?>
								<div class="img <?= ($index % 2 == 1) ? 'order-md-2' : '' ?>" style="background-image: url('data:image/jpeg;base64,<?= esc(base64_encode($a['contents_image'])) ?>')" data-aos="fade-in" data-aos-delay="100"></div>
							<?php endif; ?>
							<div class="text">
								<h2 class="heading text-dark mb-3"><?= $a['contents_title'] ;?></h2>
								<p class="mb-4"><?= word_limiter($a['contents_content'], 20); ?></p>
								<p><a href="<?= base_url('page/about-us') . '#' . $a['contents_slug'] ?>" class="btn btn-outline-dark py-2">Read more</a></p>
							</div>
						</div>
					<?php endforeach ;?>
				<?php endif ;?>
			</div>
		</div>
	</section>

	<!-- Start retroy layout blog posts -->
	<section class="blog-post">
		<div class="container align-items-center py-5">
			<div class="row mb-4">
				<div class="col-sm-6">
					<h2 class="posts-entry-title">Recent Blogs</h2>
				</div>
				<div class="col-sm-6 text-sm-end"><a href="category.html" class="read-more">View All</a></div>
			</div>
			<div class="row align-items-stretch retro-layout">
				<?php if (!empty($articles) && is_array($articles)): ?>
					<?php foreach ($articles as $index => $article): ?>
						<?php if ($index % 5 == 0): ?>
							<div class="col-md-4">
								<a href="#" class="h-entry mb-30 v-height gradient">
									<?php if ($article['image']) : ?>
										<div class="featured-img" style="background-image: url('data:image/jpeg;base64,<?= esc($article['image']) ?>');"></div>
									<?php endif; ?>
									<div class="text">
										<span class="date"><?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?></span>
										<h2><?= esc($article['title']) ?></h2>
									</div>
								</a>
								<?php if (isset($articles[$index + 3])): ?>
									<a href="#" class="h-entry v-height gradient">
										<?php if ($articles[$index + 3]['image']) : ?>
											<div class="featured-img" style="background-image: url('data:image/jpeg;base64,<?= esc($articles[$index + 3]['image']) ?>');"></div>
										<?php endif; ?>
										<div class="text">
											<span class="date"><?= date('l, d-m-Y H:i', strtotime($articles[$index + 3]['created_at'])); ?></span>
											<h2><?= esc($articles[$index + 3]['title']) ?></h2>
										</div>
									</a>
								<?php endif; ?>
							</div>
						<?php elseif ($index % 5 == 1): ?>
							<div class="col-md-4">
								<a href="#" class="h-entry img-5 h-100 gradient">
									<?php if ($article['image']) : ?>
										<div class="featured-img" style="background-image: url('data:image/jpeg;base64,<?= esc($article['image']) ?>');"></div>
									<?php endif; ?>
									<div class="text">
										<span class="date"><?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?></span>
										<h2><?= esc($article['title']) ?></h2>
									</div>
								</a>
							</div>
						<?php elseif ($index % 5 == 2): ?>
							<div class="col-md-4">
								<a href="#" class="h-entry mb-30 v-height gradient">
									<?php if ($article['image']) : ?>
										<div class="featured-img" style="background-image: url('data:image/jpeg;base64,<?= esc($article['image']) ?>');"></div>
									<?php endif; ?>
									<div class="text">
										<span class="date"><?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?></span>
										<h2><?= esc($article['title']) ?></h2>
									</div>
								</a>
								<?php if (isset($articles[$index + 2])): ?>
									<a href="#" class="h-entry v-height gradient">
										<?php if ($articles[$index + 2]['image']) : ?>
											<div class="featured-img" style="background-image: url('data:image/jpeg;base64,<?= esc($articles[$index + 2]['image']) ?>');"></div>
										<?php endif; ?>
										<div class="text">
											<span class="date"><?= date('l, d-m-Y H:i', strtotime($articles[$index + 2]['created_at'])); ?></span>
											<h2><?= esc($articles[$index + 2]['title']) ?></h2>
										</div>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="col-md-12">
						<p class="text-center">No articles found</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- End retroy layout blog posts -->
	<?= $this->include('templates/footer') ?>
<?= $this->endSection(); ?>

