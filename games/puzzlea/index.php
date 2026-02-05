<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Puzzle Game</title>

<style>
body{
margin:0;
background:#030b1a;
color:white;
font-family:Arial;
text-align:center;
}
h1{color:#00eaff;margin-top:10px}

#hud{
display:flex;
justify-content:space-around;
margin:10px;
font-size:18px;
}

#game{
width:360px;
height:360px;
max-width:90vw;
max-height:90vw;
margin:20px auto;
display:grid;
grid-template-columns:repeat(4,1fr);
grid-template-rows:repeat(4,1fr);
gap:2px;
}

.tile{
width:100%;
height:100%;
border-radius:6px;
cursor:pointer;
background-repeat:no-repeat;
background-color:#222;
transition:0.2s;
}

.empty{
background:#020718;
}

button{
padding:10px 20px;
background:#00eaff;
border:none;
border-radius:5px;
font-weight:bold;
cursor:pointer;
}
</style>
</head>

<body>

<h1>Puzzle Game</h1>

<div id="hud">
<div>⏱ <span id="time">0</span>s</div>
<div>🧠 <span id="moves">0</span></div>
<div>⭐ <span id="score">0</span></div>
</div>

<div id="game"></div>

<button onclick="shuffle()">Acak</button>

<script>
const img = "hacker7.png";
const game = document.getElementById("game");
const timeSpan = document.getElementById("time");
const movesSpan = document.getElementById("moves");
const scoreSpan = document.getElementById("score");

let tiles = [];
let empty = 15;
let moves = 0;
let time = 0;
let timer = null;
let shuffling = false;

function init(){
    tiles=[];
    for(let i=0;i<16;i++) tiles.push(i);
    empty = 15;
    draw();
}

function draw(){
    game.innerHTML="";
    const size = game.clientWidth;
    const tileSize = size / 4;

    for(let i=0;i<16;i++){
        const d = document.createElement("div");
        d.className="tile";

        if(tiles[i]===15){
            d.classList.add("empty");
        }else{
            const x = tiles[i] % 4;
            const y = Math.floor(tiles[i] / 4);
            d.style.backgroundImage = "url("+img+")";
            d.style.backgroundSize = size+"px "+size+"px";
            d.style.backgroundPosition = (-x*tileSize)+"px "+(-y*tileSize)+"px";
        }

        d.onclick = ()=>move(i);
        game.appendChild(d);
    }
    movesSpan.textContent = moves;
}

function move(i){
    const r1 = Math.floor(i/4), c1 = i%4;
    const r2 = Math.floor(empty/4), c2 = empty%4;

    if(Math.abs(r1-r2)+Math.abs(c1-c2)===1){
        [tiles[i],tiles[empty]]=[tiles[empty],tiles[i]];
        empty=i;

        if(!shuffling){
            moves++;
            checkWin();
        }
        draw();
    }
}

function shuffle(){
    clearInterval(timer);
    time=0; moves=0;
    timeSpan.textContent=0;
    scoreSpan.textContent=0;
    shuffling=true;

    timer=setInterval(()=>{
        time++;
        timeSpan.textContent=time;
    },1000);

    for(let i=0;i<300;i++){
        const r=Math.floor(Math.random()*16);
        move(r);
    }

    shuffling=false;
    moves=0;
    draw();
}

function checkWin(){
    for(let i=0;i<16;i++){
        if(tiles[i]!==i) return;
    }
    clearInterval(timer);
    let score=1000-(moves*5+time*3);
    if(score<100) score=100;
    scoreSpan.textContent=score;
    setTimeout(()=>alert("Puzzle selesai! Skor: "+score),200);
}

window.addEventListener("resize",draw);
init();
</script>

</body>
</html>
