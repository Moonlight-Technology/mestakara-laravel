// Parallax scroll logic for layers
let LastImage = document.querySelector('.last-img');
let MidImage = document.querySelector('.mid-img');
let LeafImage = document.querySelector('.leaf-img');
let ParaImage = document.querySelector('.para-img');
let WelcomeText = document.querySelector('#landing h1');

window.addEventListener('scroll', function () {
    let value = this.window.scrollY;
    
    // ParaImage.style.left = value * 0.9 + 'px';
    ParaImage.style.top = value * 0.3 + 'px';
    LastImage.style.top = value * 0.7 + 'px';
    MidImage.style.top = value * 0 + 'px';
    LeafImage.style.left = value * 1 + 'px';
    Welcome.style.right = value * 0.9 + 'px';
})
