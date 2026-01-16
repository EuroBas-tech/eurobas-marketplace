<script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

<script>
    const MAX_VIDEO_SIZE = {{ $maximum_video_size }} * 1024 * 1024;
    const MAX_VIDEO_DURATION = {{ $maximum_video_duration }};
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('videoFile');
        const uploadCard = document.getElementById('videoUploadCard');
        const showVideoBtn = document.getElementById('showVideoBtn');
        const deleteVideoBtn = document.getElementById('deleteVideoBtn');
        const videoBtnContainer = document.getElementById('videoBtnContainer');
        let currentVideoUrl = null;
        let currentUploadId = null;

        // Reset everything to initial state
        resetToInitialState();

        // Add modal cleanup event listener
        const videoModal = document.getElementById('videoPreviewModal');
        if (videoModal) {
            videoModal.addEventListener('hidden.bs.modal', function () {
                // Clean up the modal content when it's closed
                const modalBody = this.querySelector('.modal-body');
                if (modalBody) {
                    modalBody.innerHTML = '<video id="modalVideo" controls style="width:100%; height:auto; border-radius:8px;"></video>';
                }
            });
        }

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
                toastr.error(`{{translate("Video size")}} (${(file.size / (1024*1024)).toFixed(2)} {{translate("seconds")}}) {{translate("exceeds the limit of")}} ${(MAX_VIDEO_SIZE / (1024*1024)).toFixed(2)} {{translate("MB")}}`, 'Error');
                fileInput.value = '';
                return;
            }

            // Check duration
            const videoElement = document.createElement('video');
            videoElement.preload = 'metadata';
            videoElement.onloadedmetadata = function () {
                window.URL.revokeObjectURL(videoElement.src);
                if (videoElement.duration > MAX_VIDEO_DURATION) {
                    toastr.error(`{{translate("Video duration")}} (${videoElement.duration.toFixed(2)} seconds) {{translate("exceeds the limit of")}} ${MAX_VIDEO_DURATION} {{translate("seconds")}}`, 'Error');
                    fileInput.value = '';
                    return;
                }

                // ✅ Passed both checks — start upload
                let uploadId = null;

                toastr.info('{{translate("Preparing upload link")}}...', 'Info');

                fetch("{{ route('mux.upload.video.bunny') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const uploadUrl = data.data.url;
                    uploadId = data.data.id || data.data.upload_id;

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

                    return uploadToMux(uploadUrl, file);
                    
                })
                .then(() => {
                    if (!uploadId) {
                        toastr.error('{{translate("Upload ID not found, cannot get video URL")}}', 'Error');
                        return;
                    }

                    // Add delay and retry logic
                    setTimeout(() => {
                        getVideoUrlWithRetry(uploadId, 0);
                    }, 3000);
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('{{translate("Error uploading video")}}.', 'Error');
                    resetToInitialState();
                });
            };
            videoElement.onerror = function() {
                toastr.error('{{translate("Error reading video metadata. Please try another video file")}}.', 'Error');
                fileInput.value = '';
            };
            videoElement.src = URL.createObjectURL(file);
        });
        
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
            const maxRetries = 5;
            
            fetch("{{ route('mux.get.bunny.video.url') }}", {
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
                // Store the response for later use
                const response = res;
                return res.json().then(data => ({ response, data }));
            })
            .then(({ response, data }) => {
                if (data.success) {
                    toastr.success('{{translate("video_uploaded_successfully")}}', '{{translate("Success")}}');
                    window.isVideoUploaded = true; // Add this line

                    // Store video URL and upload ID
                    currentVideoUrl = data.video_url;
                    currentUploadId = uploadId;

                    // Replace with check icon and update text
                    const uploadIcon = document.querySelector('#videoUploadCard i');
                    const uploadText = document.querySelector('#videoUploadCard span');
                    if (uploadIcon) {
                        uploadIcon.className = "bi bi-check-lg text-success";
                        uploadIcon.style.fontSize = "2.5rem";
                    }
                    if (uploadText) {
                        uploadText.textContent = '';
                    }

                    if (videoBtnContainer) {
                        videoBtnContainer.classList.remove('d-none');
                        videoBtnContainer.classList.add('d-flex');
                    }

                } else if (response.status === 202 && retryCount < maxRetries) {
                    // Video still processing, retry after delay
                    setTimeout(() => {
                        getVideoUrlWithRetry(uploadId, retryCount + 1);
                    }, 5000);
                } else {
                    toastr.warning(data.error || '{{translate("Failed to get video URL after multiple attempts")}}', 'Warning');
                    resetToInitialState();
                }
            })
            .catch(err => {
                console.error(err);
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

                fetch("{{ route('mux.delete.bunny.video') }}", {
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

                        // Call the deselection function if it exists
                        if (typeof window.deselectVideoPackages === 'function') {
                            window.deselectVideoPackages();
                        }

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

        // Function to reset everything to initial state
        function resetToInitialState() {
            // Reset variables
            currentVideoUrl = null;
            currentUploadId = null;
            window.isVideoUploaded = false;

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

            // Clear video modal - restore the original video element
            const modalBody = document.querySelector('#videoPreviewModal .modal-body');
            if (modalBody) {
                modalBody.innerHTML = '<video id="modalVideo" controls style="width:100%; height:auto; border-radius:8px;"></video>';
            }

            // Clear sessions via AJAX
            fetch("{{ route('mux.clear.video.session') }}", {
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
            const modalBody = document.querySelector('#videoPreviewModal .modal-body');
            if (modalBody) {
                // Extract playback ID from the m3u8 URL
                const playbackId = videoUrl.replace('https://stream.mux.com/', '').replace('.m3u8', '');
                
                // Clear and set the mux-player content
                modalBody.innerHTML = `
                    <mux-player
                        stream-type="on-demand"
                        playback-id="${playbackId}"
                        metadata-video-title="Uploaded Video"
                        accent-color="#0F407D"
                        style="width: 98%;height: 400px;max-height: 400px;aspect-ratio: 16 / 9.45;"
                    ></mux-player>
                `;
                
                // Show the modal
                const videoModal = new bootstrap.Modal(document.getElementById('videoPreviewModal'));
                videoModal.show();
            }
        }
    });
</script>