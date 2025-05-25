import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Image upload preview
document.addEventListener('DOMContentLoaded', function() {
    const featuredImageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image-preview');
    
    if (featuredImageInput && imagePreview) {
        featuredImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Handle multiple image uploads in the post editor
    const imageUploader = document.getElementById('image-uploader');
    const imageGallery = document.getElementById('image-gallery');
    
    if (imageUploader && imageGallery) {
        // Initialize sortable for image gallery
        if (typeof Sortable !== 'undefined') {
            new Sortable(imageGallery, {
                animation: 150,
                ghostClass: 'bg-blue-100',
                onEnd: function(evt) {
                    updateImageOrder();
                }
            });
        }
        
        // Handle drag and drop uploads
        const dropZone = document.getElementById('drop-zone');
        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }
            
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                handleFiles(files);
            }
        }
        
        // Handle file selection via input
        imageUploader.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        function handleFiles(files) {
            [...files].forEach(uploadFile);
        }
        
        function uploadFile(file) {
            // Only process image files
            if (!file.type.match('image.*')) {
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const postId = document.getElementById('post_id')?.value;
                if (!postId) return; // Need post ID for upload
                
                // Create placeholder for this image
                const placeholder = document.createElement('div');
                placeholder.className = 'relative w-32 h-32 m-2 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center';
                placeholder.innerHTML = `
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                `;
                imageGallery.appendChild(placeholder);
                
                // Create form data for upload
                const formData = new FormData();
                formData.append('post_id', postId);
                formData.append('image', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                // Upload the image
                fetch('/images/upload', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Replace placeholder with actual image
                        const imageItem = document.createElement('div');
                        imageItem.className = 'relative w-32 h-32 m-2 overflow-hidden rounded-lg group border border-gray-200';
                        imageItem.dataset.id = data.image.id;
                        imageItem.innerHTML = `
                            <img src="${data.thumbnail_url}" class="w-full h-full object-cover" alt="${data.image.alt_text || ''}">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <button type="button" class="text-white p-1" onclick="removeImage(${data.image.id})">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" name="images[]" value="${data.image.id}">
                        `;
                        
                        placeholder.replaceWith(imageItem);
                        updateImageOrder();
                    } else {
                        placeholder.remove();
                        alert('Error uploading image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    placeholder.remove();
                    alert('Error uploading image');
                });
            };
            
            reader.readAsDataURL(file);
        }
        
        // Update image order when changed
        function updateImageOrder() {
            const images = imageGallery.querySelectorAll('[data-id]');
            const order = Array.from(images).map((item, index) => {
                return {
                    id: item.dataset.id,
                    order: index
                };
            });
            
            if (order.length === 0) return;
            
            // Send new order to server
            fetch('/images/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ order })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Error updating image order');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    
    // Function to remove an image (global scope)
    window.removeImage = function(imageId) {
        if (!confirm('Are you sure you want to remove this image?')) return;
        
        fetch(`/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const imageElement = document.querySelector(`[data-id="${imageId}"]`);
                if (imageElement) {
                    imageElement.remove();
                    updateImageOrder();
                }
            } else {
                alert('Error removing image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing image');
        });
    };
    
    // Filter form handling
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        // Save current filter preset
        const savePresetBtn = document.getElementById('save-preset-btn');
        if (savePresetBtn) {
            savePresetBtn.addEventListener('click', function() {
                // This will be handled by Alpine.js in the modal
            });
        }
    }
});
