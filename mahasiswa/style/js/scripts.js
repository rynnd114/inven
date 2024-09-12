document.addEventListener("DOMContentLoaded", function() {
    var rows = document.querySelectorAll(".clickable-row");
    rows.forEach(function(row) {
        row.addEventListener("click", function() {
            window.location.href = row.getAttribute("data-href");
        });
    });
});

let allImages = [];

function previewImages(input) {
    let preview = document.querySelector('#image_preview');
    if (input.files) {
        [].forEach.call(input.files, function(file) {
            if (!allImages.includes(file)) {
                allImages.push(file);

                if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    return alert(file.name + " is not an image");
                }

                let reader = new FileReader();
                reader.addEventListener("load", function() {
                    let image = new Image();
                    image.src = this.result;
                    image.className = "img-thumbnail col-md-3";
                    preview.appendChild(image);
                });
                reader.readAsDataURL(file);
            }
        });
    }
}

document.querySelector('#images').addEventListener("change", function() {
    previewImages(this);
});

document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll(".enlarge-image");
    images.forEach(function(image) {
      image.addEventListener("click", function() {
        const imageUrl = this.querySelector('img').getAttribute("src"); // Get the src attribute of the img inside the clicked element
        const modalImage = document.getElementById("modalImage");
        modalImage.setAttribute("src", imageUrl);
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
      });
    });
  });

  function validateForm() {
    var today = new Date().toISOString().split('T')[0];
    var bookingDate = document.getElementById('booking_date').value;
    var startTime = document.getElementById('start_time').value;
    var endTime = document.getElementById('end_time').value;

    if (bookingDate < today) {
        alert('Tanggal tidak boleh kurang dari hari ini.');
        return false;
    }

    var currentTime = new Date().toTimeString().split(' ')[0];
    if (bookingDate === today && (startTime < currentTime || endTime < currentTime)) {
        alert('Waktu tidak boleh kurang dari waktu saat ini.');
        return false;
    }

    if (startTime >= endTime) {
        alert('Waktu mulai harus sebelum waktu selesai.');
        return false;
    }

    return true;
}
