<?php if(!is_api()): ?>
	<div class="bravo_footer mt-4 border-top">
		<div class="main-footer">
			<div class="container">
				<div class="row justify-content-xl-between">
                    <?php if(!empty($info_contact = clean(setting_item_with_lang('footer_info_text')))): ?>
                        <div class="col-12 col-lg-4 col-xl-3dot1 mb-6 mb-md-10 mb-xl-0">
                            <?php echo clean($info_contact); ?>

                        </div>
                    <?php endif; ?>
					<!-- <?php if($list_widget_footers = setting_item_with_lang("list_widget_footer")): ?>
                        <?php $list_widget_footers = json_decode($list_widget_footers);?>
						<?php $__currentLoopData = $list_widget_footers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-12 col-md-6 col-lg-<?php echo e($item->size ?? '3'); ?> col-xl-1dot8 mb-6 mb-md-10 mb-xl-0">
								<div class="nav-footer">
                                    <h4 class="h6 font-weight-bold mb-2 mb-xl-4"><?php echo e($item->title); ?></h4>
                                    <?php echo clean($item->content); ?>

								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?> -->
                    <div class="col-12 col-md-6 col-lg col-xl-3dot1">
                        <div class="mb-4 mb-xl-2">
                            <h4 class="h6 font-weight-bold mb-2 mb-xl-4"><?php echo e(__('Mailing List')); ?></h4>
                            <p class="m-0 text-gray-1"><?php echo e(__('Sign up for our mailing list to get latest updates and offers.')); ?></p>
                        </div>
                        <form action="<?php echo e(route('newsletter.subscribe')); ?>" class="subcribe-form bravo-subscribe-form bravo-form">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input type="text" name="email" class="form-control height-54 font-size-14 border-radius-3 border-width-2 border-color-8 email-input" placeholder="<?php echo e(__('Your Email')); ?>">
                                <div class="input-group-append ml-3">
                                    <button type="submit" class="btn-submit btn btn-sea-green border-radius-3 height-54 min-width-112 font-size-14"><?php echo e(__('Subscribe')); ?>

                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-mess"></div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
        <!-- <div class="border-top border-bottom border-color-8 space-1">
            <div class="container">
                <div class="sub-footer d-flex align-items-center justify-content-between">
                    <a class="d-inline-flex align-items-center" href="<?php echo e(url('/')); ?>" aria-label="MyTravel">
                        <?php echo get_image_tag(setting_item_with_lang('logo_id_2')); ?>

                        <span class="brand brand-dark"><?php echo e(setting_item_with_lang('logo_text')); ?></span>
                    </a>
                    <div class="footer-select bravo_topbar d-flex align-items-center">
                        <div class="mr-3">
                            <?php echo $__env->make('Language::frontend.switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <?php echo $__env->make('Core::frontend.currency-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div> -->
		<div class="copy-right">
			<div class="container context">
				<div class="row">
					<div class="col-md-12">
						<?php echo setting_item_with_lang("footer_text_left") ?? ''; ?>

						<div class="f-visa">
							<?php echo setting_item_with_lang("footer_text_right") ?? ''; ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <?php endif; ?>
    <?php if(request()->is('/')): ?>
    <div class="chat-toggle"><i class="fa fa-comment"></i></div>
    <div class="chat-box">
        <div class="chat-header">Chat</div>
        <div class="chat-body">
            <div class="message user"> Hi !!</div>
            <div class="message bot"> Halo, May I Help You??</div>
        </div>
        <input type="text" name="" id="" class="chat-input" placeholder="Ketik kata kunci untuk mencari.....">
    </div>
    <?php endif; ?>
<a class="travel-go-to u-go-to-modern" href="#" data-position='{"bottom": 15, "right": 15 }' data-type="fixed" data-offset-top="400" data-compensation="#header" data-show-effect="slideInUp" data-hide-effect="slideOutDown">
    <span class="flaticon-arrow u-go-to-modern__inner"></span>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatToggle = document.querySelector('.chat-toggle');
        const chatBox = document.querySelector('.chat-box');
        const chatBody = document.querySelector('.chat-body');
        const chatInput = document.querySelector('.chat-input');
        const questionsPerPage = 4; // Limit to 4 questions per page
        let currentPage = 1;

    // Predefined questions and answers
    const faq = [
        {
            q: "Bagaimana cara memesan kamar penginapan?", 
            a: "Anda bisa memesan kamar penginapan melalui aplikasi mestakara atau langsung melalui situs web mestakara.id. Pilih lokasi penginapan dan waktu cek in dan cek out. Pastikan untuk memeriksa deskripsi dan login sebelum memesan."
        },
        {
            q: "Apa saja yang perlu diperhatikan saat check-in di penginapan?", 
            a: "Identifikasi: Bawa identifikasi yang valid seperti KTP atau paspor. Deposit: Beberapa penginapan mungkin meminta deposit yang bisa dibayar dengan tunai atau payment lainnya. Bersedia mengikuti ketentuan yang berlaku di penginapan."
        },
        {
            q: "Apa itu check-in dan check-out?", 
            a: "Check-in: Proses masuk dilakukan mulai dari pukul 14.00. Check-out: Proses keluar dilakukan sebelum pukul 12.00."
        },
        {
            q: "Bagaimana ketentuan mengenai keterlambatan check-out?", 
            a: "Keterlambatan check-out dikenakan biaya tambahan sesuai kebijakan penginapan. Jika check-out dilakukan setelah waktu yang ditentukan tetapi sebelum pukul 17.00, Anda mungkin dikenakan biaya tambahan. Layanan kamar akan mengingatkan tamu tentang waktu check-out 15 menit sebelumnya."
        },
        {
            q: "Apa yang dimaksud dengan fasilitas penginapan?", 
            a: "Fasilitas penginapan mencakup Wi-Fi Gratis, Smart TV, kamar mandi dengan shower dan water heater, serta layanan kamar."
        },
        {
            q: "Apakah yang dimaksud dengan layanan kamar penginapan?", 
            a: "Layanan kamar penginapan (room service) adalah fasilitas untuk memesan makanan dan minuman yang akan diantar ke kamar. Layanan ini tersedia 24 jam sehari."
        },
        {
            q: "Bagaimana cara memesan makanan di penginapan?", 
            a: "Anda bisa memesan makanan melalui menu inquiry di aplikasi atau situs web mestakara, melalui layanan kamar, atau langsung di resto penginapan."
        },
        {
            q: "Bagaimana cara memesan extra bed atau layanan tambahan lainnya?", 
            a: "Anda bisa memesan extra bed dan layanan tambahan melalui menu inquiry di aplikasi/website mestakara atau melalui layanan kamar."
        },
        {
            q: "Apa yang dimaksud dengan kebijakan pembatalan?", 
            a: "Kebijakan pembatalan adalah aturan tentang pembatalan reservasi. Pastikan membaca kebijakan ini sebelum memesan untuk menghindari biaya pembatalan."
        },
        {
            q: "Apa itu staycation?", 
            a: "Staycation adalah liburan dengan menginap di penginapan lokal tanpa bepergian jauh, ideal untuk menghilangkan kebosanan dan stres."
        },
        {
            q: "Apa yang dimaksud dengan aturan jam keramaian?", 
            a: "Aturan ini bertujuan menjaga kenyamanan tamu dengan mengurangi kebisingan, terutama setelah pukul 23.00."
        },
        {
            q: "Apa itu over capacity atau melebihi kapasitas penginapan?", 
            a: "Over capacity berarti jumlah tamu melebihi batas maksimal yang diizinkan untuk kamar atau fasilitas tertentu. Biaya tambahan mungkin dikenakan, atau Anda bisa diminta memesan extra bed atau kamar tambahan."
        },
        {
            q: "Apakah diperbolehkan memindahkan atau menggeser posisi tempat tidur?", 
            a: "Dilarang memindahkan atau menggeser posisi tempat tidur."
        },
        {
            q: "Apa saja aturan menjaga kebersihan di penginapan?", 
            a: "Tamu wajib membuang sampah pada tempatnya, menjaga kebersihan kamar, dan menggunakan fasilitas dengan benar."
        },
        {
            q: "Apakah diperbolehkan membawa hewan peliharaan ke penginapan?", 
            a: "Tidak diperbolehkan membawa hewan peliharaan ke area penginapan."
        },
        {
            q: "Apakah diperbolehkan membawa benda atau senjata tajam?", 
            a: "Dilarang keras membawa benda atau senjata tajam ke penginapan."
        },
        {
            q: "Apakah diperbolehkan membawa barang terlarang seperti miras atau narkotika?", 
            a: "Dilarang membawa barang terlarang seperti miras, narkotika, psikotropika, dan zat adiktif (NAFZA)."
        },
        {
            q: "Bagaimana aturan keamanan di penginapan?", 
            a: "Simpan barang berharga di tempat aman atau brankas. Jangan membawa barang berlebihan, dan kunci kamar saat meninggalkan area."
        },
        {
            q: "Bagaimana aturan pengembalian uang deposit?", 
            a: "Uang deposit akan dikembalikan 100% jika tidak ada kerusakan pada fasilitas penginapan atau pemakaian layanan tambahan."
        },
        {
            q: "Apakah penginapan menyediakan AC?", 
            a: "Penginapan tidak menyediakan AC."
        },
        {
            q: "Apakah penginapan menyediakan water heater?", 
            a: "Penginapan menyediakan water heater."
        },
        {
            q: "Apa perbedaan tipe Saga dan Akasia?", 
            a: "Saga memiliki toilet sharing, sedangkan Akasia memiliki toilet pribadi. Akasia juga menyediakan 3 selimut, sedangkan Saga hanya 2."
        },
        {
            q: "Apa saja fasilitas dapur yang disediakan?", 
            a: "Tersedia peralatan masak, piring, gelas, dan sendok."
        },
        {
            q: "Apakah menginap sudah termasuk tiket masuk?", 
            a: "Ya, menginap sudah termasuk tiket masuk."
        },
        {
            q: "Apakah tamu yang menginap mendapatkan akses ke kolam renang?", 
            a: "Ya, tamu yang menginap mendapatkan akses ke kolam renang sesuai kapasitas yang ditentukan."
        },
        {
            q: "Apakah pembayaran bisa dilakukan dengan DP?", 
            a: "Pembayaran harus full payment maksimal 1 jam setelah pemesanan. Jika tidak, pemesanan akan dibatalkan."
        },
        {
            q: "Apakah toilet di penginapan duduk atau jongkok?", 
            a: "Semua toilet di penginapan adalah toilet duduk."
        },
        {
            q: "Apakah bisa memasuki area riverside dan glamping tanpa menginap?", 
            a: "Mohon maaf, area tersebut adalah area private dan hanya untuk tamu yang menginap."
        },
        {
            q: "Apakah bisa memesan melalui tiket.com?", 
            a: "Ya, pemesanan bisa dilakukan melalui tiket.com."
        },
        {
            q: "Apakah ada promo yang tersedia?", 
            a: "Promo bisa dilihat di media sosial kami."
        },
        {
            q: "Dimana lokasi penginapan di Bogor?", 
            a: "Lokasi di Jalan Raya Puncak Km 87, Desa Tugu Selatan, Kec. Cisarua, Kab. Bogor, Jawa Barat."
        },
        {
            q: "Apakah bisa membawa tenda sendiri?", 
            a: "Saat ini belum diperbolehkan membawa tenda sendiri."
        },
        {
            q: "Apakah anak usia 2 tahun perlu tiket masuk?", 
            a: "Tiket masuk dihitung mulai dari anak usia 3 tahun."
        },
        {
            q: "Apakah penginapan bisa untuk tamu umum seperti pasangan?", 
            a: "Ya, penginapan bisa digunakan oleh tamu umum."
        },
        {
            q: "Kapan waktu check-in dan check-out penginapan?", 
            a: "Check-in pukul 14.00 WIB, dan check-out pukul 12.00 WIB di hari berikutnya."
        }
    ];


    // Pagination function
    function paginateFAQ(page) {
        chatBody.innerHTML = ''; // Clear chat body
        const start = (page - 1) * questionsPerPage;
        const paginatedFAQ = faq.slice(start, start + questionsPerPage);

        paginatedFAQ.forEach(item => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'message bot';
            questionDiv.textContent = item.q;
            questionDiv.style.cursor = 'pointer';

            // Show answer on click
            questionDiv.addEventListener('click', function () {
                chatBody.innerHTML = ''; // Clear chat body for the answer page
                const answerDiv = document.createElement('div');
                answerDiv.className = 'message bot';
                answerDiv.textContent = item.a;
                chatBody.appendChild(answerDiv);
                chatBody.scrollTop = chatBody.scrollHeight;

                // Add the message with WhatsApp link
                const extraMessageDiv = document.createElement('div');
                extraMessageDiv.className = 'message bot';
                extraMessageDiv.innerHTML = 'Jika ada pertanyaan lainnya silahkan kembali dan mencari pertanyaan lainnya atau hubungi CS kami melalui <a href="https://wa.me/628112051616" target="_blank">WhatsApp</a>';
                chatBody.appendChild(extraMessageDiv);
            });

            chatBody.appendChild(questionDiv);
        });

        // Add pagination controls
        const paginationDiv = document.createElement('div');
        paginationDiv.className = 'message bot pagination-controls';

        if (currentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Sebelumnya';
            prevButton.className = 'pagination-btn';
            prevButton.addEventListener('click', function () {
                currentPage--;
                paginateFAQ(currentPage);
            });
            paginationDiv.appendChild(prevButton);
        }

        if (currentPage < Math.ceil(faq.length / questionsPerPage)) {
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Berikutnya';
            nextButton.className = 'pagination-btn';
            nextButton.addEventListener('click', function () {
                currentPage++;
                paginateFAQ(currentPage);
            });
            paginationDiv.appendChild(nextButton);
        }

        chatBody.appendChild(paginationDiv);
    }

    // Search filter functionality
    chatInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            const input = e.target.value.toLowerCase().trim();
            if (input) {
                chatBody.innerHTML = ''; // Clear chat body
                const filteredFAQ = faq.filter(item => item.q.toLowerCase().includes(input));

                if (filteredFAQ.length > 0) {
                    filteredFAQ.forEach(item => {
                        const questionDiv = document.createElement('div');
                        questionDiv.className = 'message bot';
                        questionDiv.textContent = item.q;
                        questionDiv.style.cursor = 'pointer';

                        // Show answer on click
                        questionDiv.addEventListener('click', function () {
                            chatBody.innerHTML = ''; // Clear chat body for the answer page
                            const answerDiv = document.createElement('div');
                            answerDiv.className = 'message bot';
                            answerDiv.textContent = item.a;
                            chatBody.appendChild(answerDiv);
                            chatBody.scrollTop = chatBody.scrollHeight;

                            // Add the message with WhatsApp link
                            const extraMessageDiv = document.createElement('div');
                            extraMessageDiv.className = 'message bot';
                            extraMessageDiv.innerHTML = 'Jika ada pertanyaan lainnya silahkan kembali dan mencari pertanyaan lainnya atau hubungi CS kami melalui <a href="https://wa.me/628112051616" target="_blank">WhatsApp</a>';
                            chatBody.appendChild(extraMessageDiv);
                        });

                        chatBody.appendChild(questionDiv);
                    });
                } else {
                    // No match found, display the timeout message
                    setTimeout(() => {
                        const botMessageDiv = document.createElement('div');
                        botMessageDiv.className = 'message bot';
                        botMessageDiv.textContent = 'Mohon Maaf Saya Tidak Mengerti Yang Anda Katakan Sementara Hubungi kami melalui ';

                        const link = document.createElement('a');
                        link.textContent = 'Whatsapp';
                        link.href = 'https://wa.me/628112051616';
                        link.target = '_blank';
                        botMessageDiv.appendChild(link);
                        chatBody.appendChild(botMessageDiv);
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }, 2000);
                }
                e.target.value = ''; // Clear input
            }
        }
    });

    // Initial load of FAQ with pagination
    paginateFAQ(currentPage);

    chatToggle.addEventListener('click', function () {
        chatBox.style.display = chatBox.style.display === 'none' || chatBox.style.display === '' ? 'block' : 'none';
    });
});


    // $(document).ready(function(){
    //     $('.chat-input').keypress(function(e){
    //         if(e.which === 13){
    //             var input = $(this).val();
    //             if(input){
    //                 $('.chat-body').append('<div class="message user">'+input+'</div>');
    //                 $(this).val('');

    //                 setTimeout(() => {
    //                     $('.chat-body').append('<div class="message bot"> Mohon Maaf Saya Tidak Mengerti apa yang Anda Katakan :(</div>');
    //                     $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
    //                 }, 10000);
    //             }
    //         }
    //     })
    // })
</script>
<?php echo $__env->make('Layout::parts.login-register-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Layout::parts.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Popup::frontend.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(Auth::id()): ?>
	<?php echo $__env->make('Media::browser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo e(asset('libs/flags/css/flag-icon.min.css')); ?>">

<?php echo \App\Helpers\Assets::css(true); ?>



<script src="<?php echo e(asset('libs/lazy-load/intersection-observer.js')); ?>"></script>
<script async src="<?php echo e(asset('libs/lazy-load/lazyload.min.js')); ?>"></script>
<script>
    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
    };

    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;
    }, false);
</script>
<script src="<?php echo e(asset('libs/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/jquery-migrate/jquery-migrate.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/header.js')); ?>"></script>
<script>
    $(document).on('ready', function () {
        $.MyTravelHeader.init($('#header'));
    });
</script>
<script src="<?php echo e(asset('libs/lodash.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js')); ?>"></script>
<script src="<?php echo e(asset('libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/bootbox/bootbox.min.js')); ?>"></script>

<script src="<?php echo e(asset('themes/mytravel/libs/fancybox/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/slick/slick.js')); ?>"></script>


<?php if(Auth::id()): ?>
	<script src="<?php echo e(asset('module/media/js/browser.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>
<script src="<?php echo e(asset('libs/carousel-2/owl.carousel.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/moment.min.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/daterangepicker.min.js")); ?>"></script>
<script src="<?php echo e(asset('libs/select2/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/js/functions.js?_ver='.config('app.version'))); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/custombox/custombox.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/custombox/custombox.legacy.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/libs/custombox/window.modal.js')); ?>"></script>

<?php if(
    setting_item('tour_location_search_style')=='autocompletePlace' || setting_item('hotel_location_search_style')=='autocompletePlace' || setting_item('car_location_search_style')=='autocompletePlace' || setting_item('space_location_search_style')=='autocompletePlace' || setting_item('hotel_location_search_style')=='autocompletePlace' || setting_item('event_location_search_style')=='autocompletePlace'
): ?>
	<?php echo App\Helpers\MapEngine::scripts(); ?>

<?php endif; ?>
<script src="<?php echo e(asset('libs/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/mytravel/js/home.js?_ver='.config('app.version'))); ?>"></script>

<?php if(!empty($is_user_page)): ?>
	<script src="<?php echo e(asset('module/user/js/user.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>
<?php if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable'])): ?>
	<div class="booking_cookie_agreement p-3 fixed-bottom">
		<div class="container d-flex ">
            <div class="content-cookie"><?php echo setting_item_with_lang('cookie_agreement_content'); ?></div>
            <button class="btn save-cookie"><?php echo setting_item_with_lang('cookie_agreement_button_text'); ?></button>
        </div>
	</div>
	<script>
        var save_cookie_url = '<?php echo e(route('core.cookie.check')); ?>';
	</script>
	<script src="<?php echo e(asset('js/cookie.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>
<?php if(setting_item('user_enable_2fa')): ?>
    <?php echo $__env->make('auth.confirm-password-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('/module/user/js/2fa.js')); ?>"></script>
<?php endif; ?>
<?php echo \App\Helpers\Assets::js(true); ?>


<?php echo $__env->yieldContent('footer'); ?>

<?php \App\Helpers\ReCaptchaEngine::scripts() ?>
<?php /**PATH E:\Projects\Coding\mestakara\mestakara\themes/Mytravel/Layout/parts/footer.blade.php ENDPATH**/ ?>