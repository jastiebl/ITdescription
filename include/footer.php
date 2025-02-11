
		
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Illumi-Tech</a> 2024</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->
		
        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= $baseUrl ?>assets/vendor/global/global.min.js"></script>
	<script src="<?= $baseUrl ?>assets/vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="<?= $baseUrl ?>assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	<script src="<?= $baseUrl ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="<?= $baseUrl ?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?= $baseUrl ?>assets/vendor/owl-carousel/owl.carousel.js"></script>
	
	
    <!-- Datatable -->
    <script src="<?= $baseUrl ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/plugins-init/datatables.init.js"></script>
	<!-- Swiper-js -->
	<script src="<?= $baseUrl ?>assets/vendor/swiper/js/swiper-bundle.min.js"></script>
	
	<!-- Apex Chart -->
	<script src="<?= $baseUrl ?>assets/vendor/apexchart/apexchart.js"></script>
	
	<!-- Chart piety plugin files -->
    <script src="<?= $baseUrl ?>assets/vendor/peity/jquery.peity.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="<?= $baseUrl ?>assets/js/dashboard/dashboard-1.js"></script>

    <script src="<?= $baseUrl ?>assets/js/custom.min.js"></script>
	<script src="<?= $baseUrl ?>assets/js/deznav-init.js"></script>
	<script src="<?= $baseUrl ?>assets/js/demo.js"></script>
    <script src="<?= $baseUrl ?>assets/js/styleSwitcher.js"></script>
	
	<script>
		$(function () {
			  $("#datepicker").datepicker({ 
					autoclose: true, 
					todayHighlight: true
			  }).datepicker('update', new Date());
		
		});

	</script>
	<script>
	 var swiper = new Swiper(".front-view-slider", {
        slidesPerView: 5,
        spaceBetween: 30,
		centeredSlides: true,
		loop:true,
        pagination: {
          el: ".room-swiper-pagination",
          clickable: true,
        },
		breakpoints: {
		  360: {
            slidesPerView: 1,
            spaceBetween: 20,
          },
		  575: {
            slidesPerView: 3,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 20,
          },
          1024: {
            slidesPerView: 3,
          },
		  1400: {
            slidesPerView: 5,
            spaceBetween: 20,
          },
		  1600: {
            slidesPerView: 5,
            spaceBetween: 30,
          },
		}
      });
	</script>
	
</body>
</html>