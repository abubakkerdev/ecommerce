
    <!-- Required vendors -->
    <script src="{{ asset('backend/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('backend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('backend/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/custom.min.js') }}"></script>
	<script src="{{ asset('backend/js/deznav-init.js') }}"></script>
	<script src="{{ asset('backend/vendor/owl-carousel/owl.carousel.js') }}"></script>

	<!-- Chart piety plugin files -->
    <script src="{{ asset('backend/vendor/peity/jquery.peity.min.js') }}"></script>

	<!-- Apex Chart -->
	<script src="{{ asset('backend/vendor/apexchart/apexchart.js') }}"></script>

	<!-- Dashboard 1 -->
	<script src="{{ asset('backend/js/dashboard/dashboard-1.js') }}"></script>
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:30,
				nav:false,
				dots: false,
				left:true,
				navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
				responsive:{
					0:{
						items:1
					},
					484:{
						items:2
					},
					882:{
						items:3
					},
					1200:{
						items:2
					},

					1540:{
						items:3
					},
					1740:{
						items:4
					}
				}
			})
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000);
		});
	</script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Toastr -->
    <script src="{{ asset('backend/js/jquery.toast.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('backend/js/sweetalert.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('backend/vendor/summernote/js/summernote.min.js') }}"></script>

    <!-- Summernote init -->
    <script src="{{ asset('backend/js/plugins-init/summernote-init.js') }}"></script>
