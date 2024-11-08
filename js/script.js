function showSection(sectionId) {
    // Sembunyikan semua section
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Tampilkan section yang dipilih
    document.getElementById(sectionId).style.display = 'block';
}

function toggleMenu() {
    const navList = document.querySelector('.nav-list');
    navList.classList.toggle('active');
}