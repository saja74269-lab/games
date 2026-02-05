const canvas = document.getElementById("game");
const ctx = canvas.getContext("2d");

const moneyText = document.getElementById("money");
const popText = document.getElementById("pop");
const worldSelect = document.getElementById("worldSelect");
const worldNameText = document.getElementById("worldName");

const tile = 40;
const rows = 10;
const cols = 10;

let map=[];
let people=[];
let mode="jalan";
let uang=9999999;
let penduduk=9999;
let currentWorld="Default";
let waktu="siang";

/* 0 tanah | 1 jalan | 2 rumah | 3 toko | 4 taman
   5 sekolah | 6 polisi | 7 pemadam | 9 kebakaran */

function initMap(){
  map=Array(rows).fill().map(()=>Array(cols).fill(0));
}
initMap();

/* ===== DRAW ===== */
function draw(){
ctx.clearRect(0,0,400,400);

for(let y=0;y<rows;y++){
for(let x=0;x<cols;x++){
let t=map[y][x];
ctx.fillStyle="#d6d3d1";

if(t==1) ctx.fillStyle="#6b7280";
if(t==2) ctx.fillStyle="#fde68a";
if(t==3) ctx.fillStyle="#93c5fd";
if(t==4) ctx.fillStyle="#86efac";
if(t==5) ctx.fillStyle="#fca5a5";
if(t==6) ctx.fillStyle="#60a5fa";
if(t==7) ctx.fillStyle="#fb923c";
if(t==9) ctx.fillStyle="#ef4444";

ctx.fillRect(x*tile,y*tile,tile,tile);
ctx.strokeRect(x*tile,y*tile,tile,tile);

const icon={1:"🛣️",2:"🏠",3:"🏪",4:"🌳",5:"🏫",6:"🚓",7:"🚒",9:"🔥"};
if(icon[t]) ctx.fillText(icon[t],x*tile+10,y*tile+28);
}
}

/* PENDUDUK */
people.forEach(p=>{
ctx.fillText("🚶",p.x,p.y);
});

moneyText.innerText=uang;
popText.innerText=penduduk;
worldNameText.innerText=currentWorld;
}

/* ===== CLICK ===== */
canvas.onclick=e=>{
let x=Math.floor(e.offsetX/tile);
let y=Math.floor(e.offsetY/tile);
if(!map[y]) return;

if(mode=="hapus"){
map[y][x]=0; draw(); return;
}

if(map[y][x]!=0) return;

const harga={
jalan:5, rumah:1, toko:1, taman:15,
sekolah:40, polisi:50, pemadam:50
};

if(uang<harga[mode]) return alert("Uang kurang!");

const kode={
jalan:1, rumah:2, toko:3, taman:4,
sekolah:5, polisi:6, pemadam:7
};

map[y][x]=kode[mode];
uang-=harga[mode];

if(mode=="rumah"){
penduduk+=5;
people.push({tx:x,ty:y,x:x*tile+12,y:y*tile+28,status:"rumah"});
}

draw();
};

/* ===== GERAK PENDUDUK (HANYA JALAN) ===== */
function movePeople(){
people.forEach(p=>{
let dir=[[1,0],[-1,0],[0,1],[0,-1]][Math.floor(Math.random()*4)];
let nx=p.tx+dir[0], ny=p.ty+dir[1];
if(map[ny] && map[ny][nx]==1){
p.tx=nx; p.ty=ny;
p.x=nx*tile+12;
p.y=ny*tile+28;
}
});
}

/* ===== EKONOMI TOKO ===== */
setInterval(()=>{
let toko=0;
for(let y=0;y<rows;y++)for(let x=0;x<cols;x++)if(map[y][x]==3)toko++;
uang+=toko;
},1000);

/* ===== SIANG / MALAM ===== */
setInterval(()=>{
waktu=waktu=="siang"?"malam":"siang";
},15000);

/* ===== PENCURI ===== */
setInterval(()=>{
if(waktu=="malam" && Math.random()<0.3){
alert("🕵️ Pencuri muncul!");
}
},12000);

/* ===== KEBAKARAN ===== */
setInterval(()=>{
if(Math.random()<0.1){
for(let y=0;y<rows;y++)for(let x=0;x<cols;x++){
if(map[y][x]==2){map[y][x]=9; alert("🔥 Kebakaran!"); draw(); return;}
}
}
},15000);

/* ===== SAVE / LOAD ===== */
function saveWorld(){
const name=prompt("Nama world:");
if(!name) return;
currentWorld=name;
localStorage.setItem("world_"+name,JSON.stringify({map,uang,penduduk,people}));
loadWorldList();
draw();
}

function loadWorld(name){
if(!name) return;
const d=JSON.parse(localStorage.getItem("world_"+name));
if(!d) return;
currentWorld=name;
map=d.map; uang=d.uang; penduduk=d.penduduk; people=d.people;
draw();
}

function loadWorldList(){
worldSelect.innerHTML='<option value="">📂 Pilih World</option>';
Object.keys(localStorage).forEach(k=>{
if(k.startsWith("world_")){
let n=k.replace("world_","");
worldSelect.innerHTML+=`<option value="${n}">${n}</option>`;
}
});
}

loadWorldList();
setInterval(()=>{movePeople(); draw();},500);
