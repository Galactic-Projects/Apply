let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();
});

searchBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();
});

function menuBtnChange() {
    const rpl = document.querySelector(".replacement");
    if(sidebar.classList.contains("open")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        rpl.setAttribute('style', 'display:flex;min-width: 60px;height: 60px;')

    } else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
        rpl.setAttribute('style', 'display:none;')
    }
}
