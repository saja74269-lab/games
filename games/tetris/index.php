<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tetris | CIT Boarding School</title>

<style>
* {
    box-sizing: border-box;
    font-family: 'Segoe UI', Arial, sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
}

.game-container {
    background: rgba(0,0,0,0.65);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    text-align: center;
    width: 100%;
    max-width: 380px;
}

/* ===== HEADER SCHOOL ===== */
.school-header img {
    width: 80px;
    margin-bottom: 10px;
}

.school-header h2 {
    font-size: 16px;
    margin: 0;
    line-height: 1.4;
    letter-spacing: 0.5px;
}

.school-header p {
    font-size: 12px;
    opacity: 0.85;
    margin: 6px 0 14px;
}

/* ===== GAME ===== */
h1 {
    margin: 6px 0 10px;
    letter-spacing: 4px;
}

canvas {
    background: #111;
    border-radius: 12px;
    width: 100%;
    height: auto;
}

.score {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
}

.info {
    font-size: 13px;
    opacity: 0.85;
    margin-bottom: 10px;
}

button {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(to right, #0072ff, #00c6ff);
    color: #fff;
    cursor: pointer;
    font-size: 14px;
    transition: transform 0.2s, box-shadow 0.2s;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.4);
}
</style>
</head>

<body>

<div class="game-container">

    <!-- ===== IDENTITAS SEKOLAH ===== -->
    <div class="school-header">
        <img src="logo.png" alt="Logo CIT">
        <h2>
            CIT Boarding School<br>
            Manahilul Ilmi Bogor
        </h2>
        <p>
            Kp. Mulyasari, Desa Karyasari, RT 01/RW 03<br>
            Kecamatan Leuwiliang, Kabupaten Bogor
        </p>
    </div>

    <!-- ===== GAME ===== -->
    <h1>TETRIS</h1>

    <canvas id="tetris" width="240" height="400"></canvas>

    <div class="score">Score: <span id="score">0</span></div>

    <div class="info">
        ⬅️ ➡️ Geser &nbsp;|&nbsp; ⬆️ Rotasi &nbsp;|&nbsp; ⬇️ Turun
    </div>

    <button id="playBtn">▶ Play Music</button>

</div>

<audio id="bgm" loop>
    <source src="backsound.mp3" type="audio/mpeg">
</audio>

<script>
/* ================= CANVAS ================= */
const canvas = document.getElementById('tetris');
const ctx = canvas.getContext('2d');
ctx.scale(20, 20);

/* ================= AUDIO ================= */
const bgm = document.getElementById('bgm');
document.getElementById('playBtn').onclick = () => {
    bgm.volume = 0.4;
    bgm.play();
};

/* ================= MATRIX ================= */
function createMatrix(w, h) {
    return Array.from({ length: h }, () => new Array(w).fill(0));
}

function createPiece(type) {
    if (type === 'T') return [[0,1,0],[1,1,1],[0,0,0]];
    if (type === 'O') return [[2,2],[2,2]];
    if (type === 'L') return [[0,3,0],[0,3,0],[0,3,3]];
    if (type === 'J') return [[0,4,0],[0,4,0],[4,4,0]];
    if (type === 'I') return [[0,5,0,0],[0,5,0,0],[0,5,0,0],[0,5,0,0]];
    if (type === 'S') return [[0,6,6],[6,6,0],[0,0,0]];
    if (type === 'Z') return [[7,7,0],[0,7,7],[0,0,0]];
}

/* ================= GAME STATE ================= */
const arena = createMatrix(12, 20);
const player = { pos: {x:0,y:0}, matrix:null };
let score = 0;
const scoreEl = document.getElementById('score');

/* ================= LOGIC ================= */
function collide(arena, player) {
    const m = player.matrix;
    const o = player.pos;
    for (let y=0;y<m.length;y++) {
        for (let x=0;x<m[y].length;x++) {
            if (m[y][x] !== 0 &&
               (arena[y+o.y] && arena[y+o.y][x+o.x]) !== 0) {
                return true;
            }
        }
    }
    return false;
}

function merge(arena, player) {
    player.matrix.forEach((row,y)=>{
        row.forEach((v,x)=>{
            if(v!==0) arena[y+player.pos.y][x+player.pos.x]=v;
        });
    });
}

function arenaSweep() {
    let rows = 0;
    outer: for (let y=arena.length-1;y>=0;y--) {
        for (let x=0;x<arena[y].length;x++) {
            if (arena[y][x]===0) continue outer;
        }
        arena.splice(y,1);
        arena.unshift(new Array(arena[0].length).fill(0));
        y++;
        rows++;
    }
    if(rows>0){
        const table=[0,100,300,500,800];
        score+=table[rows];
        scoreEl.innerText=score;
    }
}

function rotate(m) {
    return m[0].map((_,i)=>m.map(r=>r[i]).reverse());
}

function playerRotate() {
    const pos=player.pos.x;
    let offset=1;
    player.matrix=rotate(player.matrix);
    while(collide(arena,player)){
        player.pos.x+=offset;
        offset=-(offset+(offset>0?1:-1));
        if(offset>player.matrix[0].length){
            player.matrix=rotate(player.matrix);
            player.pos.x=pos;
            return;
        }
    }
}

function playerMove(dir){
    player.pos.x+=dir;
    if(collide(arena,player)) player.pos.x-=dir;
}

function playerDrop(){
    player.pos.y++;
    if(collide(arena,player)){
        player.pos.y--;
        merge(arena,player);
        arenaSweep();
        playerReset();
    }
}

function playerReset(){
    const pieces='TJLOSZI';
    player.matrix=createPiece(pieces[Math.random()*pieces.length|0]);
    player.pos.y=0;
    player.pos.x=(arena[0].length/2|0)-(player.matrix[0].length/2|0);
    if(collide(arena,player)){
        arena.forEach(r=>r.fill(0));
        score=0;
        scoreEl.innerText=0;
    }
}

/* ================= DRAW ================= */
const colors=[null,'#ff0d72','#0dc2ff','#0dff72','#f538ff','#ff8e0d','#ffe138','#3877ff'];

function drawMatrix(m,o){
    m.forEach((r,y)=>{
        r.forEach((v,x)=>{
            if(v!==0){
                ctx.fillStyle=colors[v];
                ctx.fillRect(x+o.x,y+o.y,1,1);
            }
        });
    });
}

function draw(){
    ctx.fillStyle='#000';
    ctx.fillRect(0,0,canvas.width,canvas.height);
    drawMatrix(arena,{x:0,y:0});
    drawMatrix(player.matrix,player.pos);
}

/* ================= LOOP ================= */
let dropCounter=0, dropInterval=800, lastTime=0;

function update(time=0){
    const delta=time-lastTime;
    lastTime=time;
    dropCounter+=delta;
    if(dropCounter>dropInterval){
        playerDrop();
        dropCounter=0;
    }
    draw();
    requestAnimationFrame(update);
}

/* ================= INPUT ================= */
document.addEventListener('keydown',e=>{
    if(e.key==='ArrowLeft') playerMove(-1);
    else if(e.key==='ArrowRight') playerMove(1);
    else if(e.key==='ArrowDown') playerDrop();
    else if(e.key==='ArrowUp') playerRotate();
});

/* ================= START ================= */
playerReset();
update();
</script>

</body>
</html>
