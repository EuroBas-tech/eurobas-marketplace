<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
    .video-pricing-card {
        background: linear-gradient(135deg, #1e3c72, #2758acff);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
    }

    .video-pricing-card h2 {
        font-size: 38px;
    }
    
    .video-pricing-card h5 {
        font-size: 16px;
    }

    .pricing-card-box {
        max-width: 210px;
    }

    .video-pricing-card.active {
        box-shadow: 0px 0px 5px #00000075;
        transform: scale(1.1);
        transition: .2s;
    }

    .video-pricing-card .check-icon {
        color: white !important;
    }

        /* Button transition styles */
    #sponsor-submit-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    #sponsor-submit-btn .button-content {
        position: relative;
        z-index: 2;
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .video-modal {
        width: 50%;
        max-width: 600px;
    }

    /* Light ray animation */
    .light-ray {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.2) 20%, 
            rgba(255, 255, 255, 0.6) 50%, 
            rgba(255, 255, 255, 0.2) 80%, 
            transparent 100%
        );
        z-index: 1;
        animation: lightRayPass 0.6s ease-out;
    }

    @keyframes lightRayPass {
        0% {
            left: -50%;
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            left: 100%;
            opacity: 0;
        }
    }

    /* Slide animations */
    .slide-out-right {
        transform: translateX(20px);
        opacity: 0;
    }

    .slide-in-left {
        transform: translateX(-20px);
        opacity: 0;
    }

    .slide-in-center {
        transform: translateX(0);
        opacity: 1;
    }

    mux-player::part(control-button) {
        background-color: #0F407D !important;
    }

    media-control-bar :is([role='button'], [role='switch'], button):hover {
        background-color: #0F407D !important;
    }

</style>

<div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 px-3">
    <div>
        <form method="POST" action="{{route('store.sponsor')}}" enctype="multipart/form-data">
            <input type="hidden" name="type" value="{{$sponsor_type}}">
            @csrf

            <div class="col-xl-12 mb-4">
                <div class="form-group">
                    <h1 class="pt-4 pb-3 sponsor-title" >{{translate('Promote Your ads with fast and high quality videos')}}</h1>
                </div>
            </div>

            @include('theme-views.sponsor.partials._user-ads', ['user_ads' => $user_ads])

            <div class="mt-4">
                <div>
                    <h5 class="mb-3">{{ translate('Upload Promotional Video') }}</h5>

                    <!-- Hidden file input -->
                    <input type="file" id="videoFile" name="video" accept="video/*" style="display: none;">

                    <div class="d-flex align-items-start align-items-sm-center flex-sm-row flex-column gap-3" >
                        <div class="d-flex align-items-center gap-2" >
                            <!-- Clickable upload card -->
                            <div id="videoUploadCard"
                                class="d-flex flex-column align-items-center justify-content-center"
                                style="
                                    width: 140px;
                                    height: 140px;
                                    min-width: 140px;
                                    min-height: 140px;
                                    border: 1px dashed #0f407d;
                                    border-radius: 16px;
                                    cursor: pointer;
                                    color: #0f407d;
                                ">
                                <i class="bi bi-camera-video" style="font-size: 2.5rem;"></i>
                                <span class="mt-2 text-center">{{ translate('Click to upload') }}</span>
                                <div id="videoBtnContainer" class="mt-1 d-none gap-2">
                                    <small id="showVideoBtn" class="text-success" style="cursor: pointer; text-decoration: underline;">{{translate('Show video')}}</small>
                                    <small id="deleteVideoBtn" class="text-danger" style="cursor: pointer; text-decoration: underline;">{{translate('delete')}}</small>
                                </div>
                            </div>
                            <div class="mt-3 w-100" id="globalVideoProgress" ></div>
                        </div>

                        <div class="card p-4 bg-light" style="border-radius: 13px;border: 1px dashed #0f407d;">
                            <h4 class="mb-3" >
                                <span><i class="bi bi-clock-fill mx-1"></i></span>
                                <span class="fw-medium" >{{ translate('maximum_duration') }}</span> : 
                                <span>{{ $maximum_video_duration }} {{translate('seconds')}}.</span>
                            </h4>
                            <h4>
                                <span><i class="bi bi-hdd-rack-fill mx-1"></i></span>
                                <span class="fw-medium" >{{ translate('maximum_size') }}</span> : 
                                <span>{{ $maximum_video_size }} {{translate('Mb')}}.</span>
                            </h4>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Video Preview Modal -->
            <div class="modal fade" id="videoPreviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-body p-0">
                        <video id="modalVideo" controls style="width:100%; height:auto; border-radius:8px;"></video>
                    </div>
                    </div>
                </div>
            </div>

            <div class="my-sm-5 my-4">  
                <div class="row">  
                    @foreach($packages as $package)  
                        <div class="col-md-3 d-flex pricing-card-box position-relative mb-sm-2 mb-4">  
                            <div class="video-pricing-card text-center text-white d-flex flex-column justify-content-center align-items-center w-100 px-2 pt-3 pb-4 rounded-4 position-relative">  
                                <!-- package name (needed for JS toastr message) -->
                                <h5 class="package-name d-none">{{ $package->name ?? 'Package' }}</h5>  

                                <h2 class="fw-bold mb-2 text-white">€{{ number_format($package['price'], 2) }}</h2>  
                                <h5 class="fw-light mb-3 text-white">{{ translate('for') }} {{ $package->duration_in_days }} {{ translate('Days') }}</h5>  

                                <!-- button must be .btn-primary with data-id -->
                                <button type="button" class="btn btn-light video-package-btn text-primary rounded-pill mt-auto px-4" data-id="{{ $package->id }}">  
                                    {{ translate('get_started') }}  
                                </button>  
                            </div>  
                        </div>  
                    @endforeach
                </div>
            </div>

            <!-- Video Modal -->
            <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                <div class="modal-dialog video-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel">Promotional Video</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="videoContainer" class="text-center">
                                <!-- Video iframe will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4"> 
                <div> 
                    <button id="sponsor-submit-btn" type="submit" class="btn btn-primary d-flex align-items-center gap-1"> 
                        <span><i class="bi bi-floppy"></i></span> 
                        <span>{{translate('payment_checkout')}}</span>
                    </button> 
                </div> 
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        // Add these constants at the top (replace with your actual values)
        const MAX_VIDEO_SIZE = {{ $maximum_video_size }} * 1024 * 1024; // Convert MB to bytes
        const MAX_VIDEO_DURATION = {{ $maximum_video_duration }};

        const fileInput = document.getElementById('videoFile');
        const uploadCard = document.getElementById('videoUploadCard');
        const showVideoBtn = document.getElementById('showVideoBtn');
        const deleteVideoBtn = document.getElementById('deleteVideoBtn');
        const videoBtnContainer = document.getElementById('videoBtnContainer');
        let currentVideoUrl = null;
        let currentUploadId = null;
        
        // *** DECLARE THE GLOBAL VARIABLE ***
        window.isVideoUploaded = false;

        // Reset everything to initial state
        resetToInitialState();

        // Open file picker when clicking on the card
        if (uploadCard && fileInput) {
            uploadCard.addEventListener('click', () => {
                // Only allow click if not in uploaded state
                if (!currentVideoUrl) {
                    fileInput.click();
                }
            });
        }

        // Show video modal when clicking "Show video" button
        if (showVideoBtn) {
            showVideoBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentVideoUrl) {
                    showVideoModal(currentVideoUrl);
                }
            });
        }

        // Delete video when clicking "Delete" button
        if (deleteVideoBtn) {
            deleteVideoBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentUploadId) {
                    deleteVideo(currentUploadId);
                }
            });
        }

        // Auto-upload when a file is chosen
        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (!file) return;

            // Check size
            if (file.size > MAX_VIDEO_SIZE) {
                toastr.error(`{{translate("Video size")}} (${(file.size / (1024*1024)).toFixed(2)} {{translate("MB")}}) {{translate("exceeds the limit of")}} {{ $maximum_video_size }} {{translate("MB")}}`, 'Error');
                fileInput.value = '';
                return;
            }

            // Check duration
            const videoElement = document.createElement('video');
            videoElement.preload = 'metadata';
            
            videoElement.onloadedmetadata = function () {
                window.URL.revokeObjectURL(videoElement.src);
                if (videoElement.duration > MAX_VIDEO_DURATION) {
                    toastr.error(`{{translate("Video duration")}} (${videoElement.duration.toFixed(2)} {{translate("seconds")}}) {{translate("exceeds the limit of")}} {{ $maximum_video_duration }} {{translate("seconds")}}`, '{{translate("Error")}}');
                    fileInput.value = '';
                    return;
                }

                // Start the upload process
                startUpload(file);
            };
            
            videoElement.onerror = function() {
                toastr.error('{{translate("Error reading video metadata. Please try another video file")}}.', 'Error');
                fileInput.value = '';
            };
            
            videoElement.src = URL.createObjectURL(file);
        });
        
        // Function to start the upload process
        function startUpload(file) {
            let uploadId = null;
            let uploadUrl = null;

            toastr.info('{{translate("Preparing upload link")}}...', 'Info');

            // Step 1: Get upload URL from backend
            fetch("{{ route('upload.video.bunny') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').content
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {                
                if (!data.success && data.data) {
                    // Handle Laravel response structure
                    uploadUrl = data.data.url;
                    uploadId = data.data.id || data.data.upload_id;
                } else if (data.data) {
                    uploadUrl = data.data.url;
                    uploadId = data.data.id || data.data.upload_id;
                } else {
                    throw new Error('Invalid response format');
                }
                
                // Replace icon with spinner
                const uploadIcon = document.querySelector('#videoUploadCard i');
                const uploadText = document.querySelector('#videoUploadCard span');
                if (uploadIcon) {
                    uploadIcon.className = "spinner-border text-primary";
                    uploadIcon.style.fontSize = "";
                }
                if (uploadText) {
                    uploadText.textContent = "{{translate('Uploading')}}...";
                }

                // Step 2: Upload file directly to Mux using XMLHttpRequest for better control
                return uploadToMux(uploadUrl, file);
            })
            .then(() => {
                if (!uploadId) {
                    throw new Error('Upload ID not found');
                }

                toastr.info('{{translate("Processing video")}}...', 'Info');

                // Add delay before checking video status
                setTimeout(() => {
                    getVideoUrlWithRetry(uploadId, 0);
                }, 3000);
            })
            .catch(err => {
                toastr.error('{{translate("Error uploading video")}} : ' + err.message, 'Error');
                resetToInitialState();
            });
        }
        
        // Function to upload file to Mux using XMLHttpRequest
        function uploadToMux(uploadUrl, file) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                
                xhr.addEventListener('load', () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resolve();
                    } else {
                        reject(new Error(`Upload failed with status ${xhr.status}`));
                    }
                });
                
                xhr.addEventListener('error', () => {
                    reject(new Error('Network error during upload'));
                });
                
                xhr.addEventListener('abort', () => {
                    reject(new Error('Upload aborted'));
                });
                
                xhr.open('PUT', uploadUrl, true);
                xhr.send(file);
            });
        }
        
        // Helper function to retry getting video URL
        function getVideoUrlWithRetry(uploadId, retryCount) {
            const maxRetries = 10; // Increased retries for Mux processing
            
            fetch("{{ route('get.bunny.video.url') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    upload_id: uploadId
                })
            })
            .then(res => {
                const status = res.status;
                return res.json().then(data => ({status, data}));
            })
            .then(({status, data}) => {
                if (data.success) {
                    toastr.success('{{translate("video_uploaded_successfully")}}', '{{translate("Success")}}');
                    // Store video URL and upload ID
                    currentVideoUrl = data.video_url;
                    currentUploadId = uploadId;

                    // Set the global variable to TRUE when video is uploaded successfully
                    if (typeof isVideoUploaded !== 'undefined') {
                        isVideoUploaded = true;
                    }

                    // Replace with check icon and update text
                    const uploadIcon = document.querySelector('#videoUploadCard i');
                    const uploadText = document.querySelector('#videoUploadCard span');
                    if (uploadIcon) {
                        uploadIcon.className = "bi bi-check-lg text-success";
                        uploadIcon.style.fontSize = "2.5rem";
                    }
                    if (uploadText) {
                        uploadText.textContent = "";
                    }

                    if (videoBtnContainer) {
                        videoBtnContainer.classList.remove('d-none');
                        videoBtnContainer.classList.add('d-flex');
                    }

                } else if (status === 202 && retryCount < maxRetries) {
                    // Video still processing, retry after delay
                    toastr.info(`{{translate("Processing video")}}... (attempt ${retryCount + 1}/${maxRetries + 1})`, 'Info');
                    setTimeout(() => {
                        getVideoUrlWithRetry(uploadId, retryCount + 1);
                    }, 5000); // 5 second delay between retries
                } else {
                    toastr.warning(data.error || '{{translate("Failed to get video URL after multiple attempts")}}', 'Warning');
                    resetToInitialState();
                }
            })
            .catch(err => {
                if (retryCount < maxRetries) {
                    setTimeout(() => {
                        getVideoUrlWithRetry(uploadId, retryCount + 1);
                    }, 5000);
                } else {
                    toastr.error('{{translate("Error getting video URL after multiple attempts")}}.', 'Error');
                    resetToInitialState();
                }
            });
        }

        // Function to delete video
        function deleteVideo(uploadId) {
            if (confirm('Are you sure you want to delete this video?')) {
                toastr.info('{{translate("Deleting video")}}...', 'Info');

                fetch("{{ route('delete.bunny.video') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        upload_id: uploadId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('{{translate("Video deleted successfully")}}', 'Success');
                        resetToInitialState();
                    } else {
                        toastr.error(data.error || '{{translate("Failed to delete video")}}', 'Error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('{{translate("Error deleting video")}}.', 'Error');
                });
            }
        }

        // Function to deselect all packages
        function deselectAllPackages() {
            // Remove active state from all cards
            document.querySelectorAll('.video-pricing-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Remove all check icons
            document.querySelectorAll('.check-icon').forEach(icon => icon.remove());
            
            // Remove all hidden package_id inputs
            document.querySelectorAll('#package_id').forEach(input => input.remove());
            
            // Reset all buttons to "get_started" text
            document.querySelectorAll('.video-package-btn').forEach(btn => {
                btn.innerHTML = `{{ translate('get_started') }}`;
            });
            
            // Reset currently selected ID
            if (typeof currentlySelectedId !== 'undefined') {
                currentlySelectedId = null;
            }
            
            // Hide payment section
            if (typeof hidePaymentSection === 'function') {
                hidePaymentSection();
            }
            
            // Update submit button to "add" state
            if (typeof updateSubmitButtonText === 'function') {
                updateSubmitButtonText(0);
            }
        }

        // Function to reset everything to initial state
        function resetToInitialState() {
            // Reset variables
            currentVideoUrl = null;
            currentUploadId = null;

            // Reset the global variable to FALSE when video is deleted/reset
            if (typeof isVideoUploaded !== 'undefined') {
                isVideoUploaded = false;
            }

            // Deselect all packages when video is deleted
            deselectAllPackages();

            // Reset file input
            if (fileInput) {
                fileInput.value = '';
            }

            // Reset upload card UI
            const uploadIcon = document.querySelector('#videoUploadCard i');
            const uploadText = document.querySelector('#videoUploadCard span');
            if (uploadIcon) {
                uploadIcon.className = "bi bi-camera-video";
                uploadIcon.style.fontSize = "2.5rem";
            }
            if (uploadText) {
                uploadText.textContent = "{{ translate('Click to upload') }}";
            }

            if (videoBtnContainer) {
                videoBtnContainer.classList.remove('d-flex');
                videoBtnContainer.classList.add('d-none');
            }

            // Clear video modal
            const videoContainer = document.getElementById('videoContainer');
            if (videoContainer) {
                videoContainer.innerHTML = '';
            }

            // Clear sessions via AJAX
            fetch("{{ route('clear.video.session') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').content
                }
            }).catch(err => {
                console.log('Session clear request failed, but continuing...');
            });
        }

        // Function to show video in modal
        function showVideoModal(videoUrl) {
            const videoContainer = document.getElementById('videoContainer');
            if (videoContainer) {
                // Extract playback ID from the m3u8 URL
                // Format: https://stream.mux.com/{playback_id}.m3u8
                const playbackId = videoUrl.replace('https://stream.mux.com/', '').replace('.m3u8', '');
                
                console.log('Playback ID:', playbackId);
                console.log('Video URL:', videoUrl);
                
                // Use Mux Player element instead of iframe
                videoContainer.innerHTML = `
                    <mux-player
                        stream-type="on-demand"
                        playback-id="${playbackId}"
                        metadata-video-title="Uploaded Video"
                        accent-color="#0F407D"
                        style="width: 98%;height: auto;max-height: 600px;aspect-ratio: 16 / 9.45;"
                    ></mux-player>
                `;
                
                // Show the modal
                const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
                videoModal.show();
            }
        }

    });
    
</script>

<script> 
    const packagePrices = @json($packages->pluck('price', 'id')); 
</script> 

<script>  
    document.addEventListener("DOMContentLoaded", function () {  
        // TARGET ONLY THE PACKAGE BUTTONS WITH SPECIFIC CLASS
        const buttons = document.querySelectorAll('.video-package-btn');  
        const paymentSection = document.querySelector('.payment-method-container'); 
        const submitButton = document.querySelector('#sponsor-submit-btn');  
        let currentlySelectedId = null;  

        // --- Initialize button content wrapper (for smooth animation) ---
        function initializeButtonContent() { 
            if (submitButton && !submitButton.querySelector('.button-content')) { 
                const content = submitButton.innerHTML; 
                submitButton.innerHTML = `<div class="button-content">${content}</div>`; 
            } 
        } 

        // --- Light ray effect ---
        function createLightRay() { 
            if (!submitButton) return; 
            const lightRay = document.createElement('div'); 
            lightRay.className = 'light-ray'; 
            submitButton.appendChild(lightRay); 
            setTimeout(() => { 
                if (lightRay && lightRay.parentNode) { 
                    lightRay.parentNode.removeChild(lightRay); 
                } 
            }, 600); 
        } 

        // --- Track current button state ---
        let currentButtonState = 'checkout'; // 'add' or 'checkout' 

        // --- Update submit button text with smooth animation ---
        function updateSubmitButtonText(packagePrice) { 
            if (!submitButton) return; 
            const buttonContent = submitButton.querySelector('.button-content'); 
            if (!buttonContent) return; 

            const newState = packagePrice > 0 ? 'checkout' : 'add'; 
            if (currentButtonState === newState) return; // no change needed

            currentButtonState = newState; 

            // Slide out current text 
            buttonContent.classList.add('slide-out-right'); 

            setTimeout(() => { 
                if (packagePrice > 0) { 
                    buttonContent.innerHTML = ` 
                        <span><i class="bi bi-floppy"></i></span>  
                        <span>{{translate('payment_checkout')}}</span> 
                    `; 
                } else { 
                    buttonContent.innerHTML = ` 
                        <span><i class="bi bi-floppy"></i></span>  
                        <span>{{translate('add')}}</span> 
                    `; 
                } 

                buttonContent.classList.remove('slide-out-right'); 
                buttonContent.classList.add('slide-in-left'); 

                createLightRay(); 

                setTimeout(() => { 
                    buttonContent.classList.remove('slide-in-left'); 
                    buttonContent.classList.add('slide-in-center'); 
                    setTimeout(() => { 
                        buttonContent.classList.remove('slide-in-center'); 
                    }, 300); 
                }, 50); 
            }, 200); 
        } 

        // --- Payment section transitions ---
        if (paymentSection) { 
            paymentSection.style.transition = 'all 0.4s ease-in-out'; 
        } 
        function showPaymentSection() { 
            if (paymentSection) { 
                paymentSection.style.display = 'block'; 
                paymentSection.offsetHeight; 
                paymentSection.style.opacity = '1'; 
                paymentSection.style.transform = 'translateY(0)'; 
            } 
        } 
        function hidePaymentSection() { 
            if (paymentSection) { 
                paymentSection.style.opacity = '0'; 
                paymentSection.style.transform = 'translateY(-20px)'; 
                setTimeout(() => { 
                    paymentSection.style.display = 'none'; 
                }, 400); 
            } 
        } 

        // --- Initialize submit button ---
        initializeButtonContent(); 

        // --- Package selection handling ---
        buttons.forEach(button => {  
            button.addEventListener('click', function () {  
                // *** CHECK IF VIDEO IS UPLOADED BEFORE ALLOWING PACKAGE SELECTION ***
                if (!isVideoUploaded) {
                    toastr.error('{{translate("Upload the video first to select a price package")}}', '{{translate("Video Required")}}');
                    return; // Stop execution here if video is not uploaded
                }

                const selectedId = this.dataset.id;  
                const card = this.closest('.video-pricing-card');  
                const packageName = card.querySelector('.package-name')?.textContent || 'package';  
                const btn = this;  
                const packagePrice = packagePrices[selectedId] || 0;  

                if (currentlySelectedId === selectedId) {  
                    card.classList.remove('active');  
                    card.querySelector('.check-icon')?.remove();  
                    card.querySelector('#package_id')?.remove();  
                    currentlySelectedId = null;  
                      
                    btn.innerHTML = `{{ translate('get_started') }}`; 
 
                    hidePaymentSection(); 
                    updateSubmitButtonText(0); 

                    toastr.warning('', '{{translate("Package Removed")}}');  
                    return;  
                }  

                document.querySelectorAll('.video-pricing-card').forEach(card => {  
                    card.classList.remove('active');  
                });  
                document.querySelectorAll('.check-icon').forEach(icon => icon.remove());  
                document.querySelectorAll('#package_id').forEach(input => input.remove());  
                // CHANGED: Only reset package buttons, not all .video-package-btn buttons
                document.querySelectorAll('.video-package-btn').forEach(btn => {  
                    btn.innerHTML = `{{ translate('get_started') }}`;  
                });  

                card.classList.add('active');  
                  
                const icon = document.createElement('i');  
                icon.className = 'bi bi-check-circle-fill text-light position-absolute top-0 end-0 m-2 check-icon fs-4';  
                card.appendChild(icon);  
                  
                const hiddenInput = document.createElement('input');  
                hiddenInput.type = 'hidden';  
                hiddenInput.name = 'package_id';  
                hiddenInput.id = 'package_id';  
                hiddenInput.value = selectedId;  
                card.appendChild(hiddenInput);  
                  
                currentlySelectedId = selectedId;  
                  
                btn.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> {{ translate('selected') }}`; 
 
                if (packagePrice > 0) { 
                    showPaymentSection(); 
                } else { 
                    hidePaymentSection(); 
                } 

                updateSubmitButtonText(packagePrice); 
                toastr.success('', '{{translate("Package Selected")}}');  
            });  
        });  
    });  
</script>



