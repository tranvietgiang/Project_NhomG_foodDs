const open_navbar = document.querySelector(".nav-responsive");
const sidebar = document.querySelector(".content-wrapper");

open_navbar.addEventListener("click", (event) => {
    event.stopPropagation(); // Ngăn không cho sự kiện lan truyền lên document
    sidebar.classList.toggle("content-wrapper"); // Toggle trạng thái ẩn/hiện
});

/**
 * nếu mà nó đang show thì click ở đâu thì nó cũng hidden
 */
document.addEventListener("click", () => {
    if (!sidebar.classList.contains("content-wrapper"))
        sidebar.classList.add("content-wrapper"); // Ẩn nếu click ngoài sidebar
});

/**
 * code img-animation
 */

let active = 0; // Biến để theo dõi hình ảnh hiện tại
const totalImages = 6; // Tổng số hình ảnh
let interval; // Biến để lưu trữ interval

const sbImg = document.querySelector(".animation-header"); // Chọn phần tử hình ảnh

// Danh sách các hình ảnh (có thể thay đổi theo nhu cầu)
const images = [
    "component/header/img/img-animation-1.jpg",
    "component/header/img/img-animation-2.jpg",
    "component/header/img/img-animation-3.jpg",
    "component/header/img/img-animation-4.jpg",
    "component/header/img/img-animation-5.jpg",
    "component/header/img/img-animation-6.jpg",
];

// Hàm bắt đầu interval để tự động chuyển đổi hình ảnh
const startInterval = () => {
    interval = setInterval(nextImage, 5000); // Chuyển đổi hình ảnh mỗi 3 giây
};

// Hàm reset interval
const resetInterval = () => {
    clearInterval(interval); // Dừng interval hiện tại
    startInterval(); // Bắt đầu lại interval
};

// Hàm chuyển đến hình ảnh tiếp theo
const nextImage = () => {
    sbImg.classList.add("hidden"); // Thêm lớp hidden để ẩn hình ảnh hiện tại

    setTimeout(() => {
        active = (active + 1) % totalImages; // Di chuyển sang ảnh tiếp theo
        sbImg.src = images[active]; // Cập nhật nguồn hình ảnh
        sbImg.classList.remove("hidden"); // Xóa lớp hidden để hiển thị hình ảnh mới
    }, 500); // Thời gian trễ để đồng bộ với thời gian chuyển tiếp
};

// Hàm chuyển về hình ảnh trước
const prevImage = () => {
    sbImg.classList.add("hidden"); // Thêm lớp hidden để ẩn hình ảnh hiện tại

    setTimeout(() => {
        active = (active - 1 + totalImages) % totalImages; // Di chuyển về ảnh trước
        sbImg.src = images[active]; // Cập nhật nguồn hình ảnh
        sbImg.classList.remove("hidden"); // Xóa lớp hidden để hiển thị hình ảnh mới
    }, 500); // Thời gian trễ để đồng bộ với thời gian chuyển tiếp
};

// Gọi hàm để bắt đầu interval khi trang được tải
startInterval();

// Thêm sự kiện click cho nút tiếp theo
document.querySelector(".fa-chevron-right").addEventListener("click", () => {
    nextImage();
    resetInterval(); // Reset interval khi nhấp vào nút
});

// Thêm sự kiện click cho nút trước
document.querySelector(".fa-chevron-left").addEventListener("click", () => {
    prevImage();
    resetInterval(); // Reset interval khi nhấp vào nút
});

// dropdown menu bên css
// const menuItem = document.querySelector(".navbar-2 li:first-child");
// const dropdown = document.querySelector(".dropdown-1");

// menuItem.addEventListener("mouseenter", () => {
//     dropdown.style.height = "300px";
// });

// menuItem.addEventListener("mouseleave", () => {
//     dropdown.style.height = "0";
// });
