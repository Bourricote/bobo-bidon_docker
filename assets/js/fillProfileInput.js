const profileInput = document.getElementById('user_pictureFile');

profileInput.addEventListener('change',function (e) {
    const fileName = profileInput.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});