const canvas=document.getElementById("game");
const ctx=canvas.getContext("2d");

const moneyText=document.getElementById("money");
const popText=document.getElementById("pop");
const worldSelect=document.getElementById("worldSelect");

let tile=40;
let mapSize=10;
let map=[];
let mode="road";

let uang=100;
let penduduk=0;
let people=[];

/* INIT */
function initMap(){
 map=Array(mapSize).fill().map(()=>Array(mapSize).fill(0));
}
initMap();

/* DRAW */
function draw(){
 ctx.clearRect(0,0,canvas.width,canvas.height);

 for(let y=0;y<mapSize;y++){
  for(let x=0;x<mapSize;x++){
   ctx.fillStyle="#d1d5db";
   ctx.fillRect(x*tile,y*tile,tile,tile);

   let t=map[y][x];
   if(t==1) ctx.fillText("🛣️",x*tile+10,y*tile+28);
   if(t==2) ctx.fillText("🏠",x*tile+10,y*tile+28);
   if(t==3) ctx.fillText("🏪",x*tile+10,y*tile+28);
   if(t==4) ctx.fillText("🏭",x*tile+10,y*tile+28);
   if(t==5) ctx.fillText("🌳",x*tile+10,y*tile+28);

   ctx.strokeRect(x*tile,y*tile,tile,tile);
  }
 }

 people.forEach(p=>{
  ctx.fillText("🚶",p.x*tile+10,p.y*tile+28);
 });

 moneyText.innerText=uang;
 popText.innerText=penduduk;
}
draw();

/* CLICK */
canvas.onclick=e=>{
 let x=Math.floor(e.offsetX/tile);
 let y=Math.floor(e.offsetY/tile);
 if(!map[y]||map[y][x]!=0) return;

 if(mode=="road"&&uang>=5){map[y][x]=1;uang-=5;}
 if(mode=="res"&&uang>=20){
  map[y][x]=2;uang-=20;penduduk+=5;
  for(let i=0;i<5;i++) people.push({x,y});
 }
 if(mode=="com"&&uang>=30) {map[y][x]=3;uang-=30;}
 if(mode=="ind"&&uang>=40) {map[y][x]=4;uang-=40;}
 if(mode=="park"&&uang>=15) {map[y][x]=5;uang-=15;}
 if(mode=="erase") map[y][x]=0;

 draw();
};

/* PEOPLE MOVE (JALAN SAJA) */
setInterval(()=>{
 people.forEach(p=>{
  let d=[[1,0],[-1,0],[0,1],[0,-1]];
  let r=d[Math.floor(Math.random()*4)];
  let nx=p.x+r[0], ny=p.y+r[1];
  if(map[ny]&&map[ny][nx]==1){p.x=nx;p.y=ny;}
 });
 draw();
},800);

/* INCOME */
setInterval(()=>{
 let toko=0,pabrik=0;
 map.forEach(r=>r.forEach(t=>{
  if(t==3) toko++;
  if(t==4) pabrik++;
 }));
 uang+=toko*2+pabrik*3;
 draw();
},2000);

/* SAVE LOAD */
function saveWorld(){
 let n=prompt("Nama World:");
 if(!n) return;
 localStorage.setItem("world_"+n,JSON.stringify({map,uang,penduduk}));
 loadWorldList();
 alert("World disimpan");
}

function loadWorld(n){
 let d=JSON.parse(localStorage.getItem("world_"+n));
 if(!d) return;
 map=d.map;
 uang=d.uang;
 penduduk=d.penduduk;
 draw();
}

function loadWorldList(){
 worldSelect.innerHTML='<option value="">📂 Pilih World</option>';
 Object.keys(localStorage).forEach(k=>{
  if(k.startsWith("world_")){
   let n=k.replace("world_","");
   worldSelect.innerHTML+=`<option>${n}</option>`;
  }
 });
}
loadWorldList();
