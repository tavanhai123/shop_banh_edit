// Ngăn để không ẩn bộ lọc
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.advanced-search');
    const searchParams = new URLSearchParams(window.location.search);

    // Kiểm tra nếu có bất kỳ tham số nào trong URL không phải là trống và không phải là tham số phân trang
    const hasNonPagingParams = Array.from(searchParams.keys()).some(key => {
        const value = searchParams.get(key).trim();
        return value !== '' && key !== 'per_page' && key !== 'page';
    });

    // Mở form nếu có tham số khác phân trang
    if (hasNonPagingParams) {
        form.classList.add('open');
    }

    // Đảm bảo nút đóng hoạt động
    document.querySelector('.advanced-search-control button[onclick*="remove"]').addEventListener('click', function () {
        form.classList.remove('open');
    });
});

function keepAdvancedSearchOpen(event) {
    // Giữ form mở khi thực hiện submit
    document.querySelector('.advanced-search').classList.add('open');
    return true;
}


// Pop-up detail.php
document.addEventListener('DOMContentLoaded', function () {
    const productLinks = document.querySelectorAll('.card-image-link, .card-title-link, .product-buy');
    const modalContainer = document.createElement('div');
    modalContainer.id = 'popup-container';
    modalContainer.classList.add('modal'); // Thêm class modal cho container
    document.body.appendChild(modalContainer);

    productLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn không cho chuyển trang

            let productID;
            if (this.classList.contains('product-buy')) {
                productID = this.getAttribute('data-product-id');
            } else {
                productID = new URL(this.href).searchParams.get('ProductID');
            }

            // Gọi Ajax để tải chi tiết sản phẩm
            fetch(`detail.php?ProductID=${productID}`)
                .then(response => response.text())
                .then(html => {
                    modalContainer.innerHTML = html;
                    modalContainer.classList.add('open'); // Mở modal

                    // Thêm sự kiện đóng popup
                    const closeButton = modalContainer.querySelector('.close-popup');
                    if (closeButton) {
                        closeButton.addEventListener('click', function () {
                            closeModal();
                        });
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi tải popup chi tiết:', error);
                });
        });
    });

    // Đóng popup khi nhấn vào khoảng trống bên ngoài modal
    document.addEventListener('click', function (event) {
        if (modalContainer.classList.contains('open') && !event.target.closest('.modal-container')) {
            closeModal();
        }
    });

    function closeModal() {
        modalContainer.classList.remove('open'); // Đóng modal
        modalContainer.innerHTML = ''; // Xóa nội dung để giải phóng bộ nhớ
    }
});




