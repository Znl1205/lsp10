let login_siswa = document.getElementById("login_siswa");
let login_guru = document.getElementById("login_guru");
let login_admin = document.getElementById("login_admin");

function Siswa() {
    login_siswa.style.display = "block";
    login_guru.style.display = "none";
    login_admin.style.display = "none";
}

function Guru() {
    login_siswa.style.display = "none";
    login_guru.style.display = "block";
    login_admin.style.display = "none";
}

function Admin() {
    login_siswa.style.display = "none";
    login_guru.style.display = "none";
    login_admin.style.display = "block";
}

// Close Alert Button
var closeBtn = document.getElementById("closeBtn");

if (closeBtn) {
    closeBtn.onclick = function () {
        var alertBox = this.parentElement;
        alertBox.style.opacity = "0";
        setTimeout(function () {
            alertBox.style.display = "none";
        }, 600);
    };
}
