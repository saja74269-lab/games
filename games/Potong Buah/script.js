const arena = document.getElementById("arena");
const skorText = document.getElementById("skor");
const levelText = document.getElementById("level");
const nyawaText = document.getElementById("nyawa");
const highScoreText = document.getElementById("highscore");

const soundSlice = document.getElementById("soundSlice");
const soundBomb = document.getElementById("soundBomb");

let skor = 0;
let level = 1;
let nyawa = 3;
let gameOver = false;
let gravity = 0.25;

/* HIGH SCORE */
let highScore = localStorage.getItem("highScoreFruit") || 0;
highScoreText.innerText = highScore;

/* MOBILE SLICE */
arena.addEventListener("touchmove", (e) => {
  const t = e.touches[0];
  const el = document.elementFromPoint(t.clientX, t.clientY);
  if (el && el.classList.contains("objek")) el.click();
});

/* EFEK POTONG */
function efekBelah(x, y) {
  for (let i = 0; i < 2; i++) {
    const s = document.createElement("div");
    s.className = "slice";
    s.style.left = x + i * 20 + "px";
    s.style.top = y + "px";
    arena.appendChild(s);
    setTimeout(() => s.remove(), 600);
  }
}

/* EFEK BOM */
function efekBom(x, y) {
  const e = document.createElement("div");
  e.className = "explosion";
  e.style.left = x - 20 + "px";
  e.style.top = y - 20 + "px";
  arena.appendChild(e);
  setTimeout(() => e.remove(), 500);
}

/* CEK HIGH SCORE */
function cekHighScore() {
  if (skor > highScore) {
    highScore = skor;
    localStorage.setItem("highScoreFruit", highScore);
    highScoreText.innerText = highScore;
  }
}

/* LEMPAR OBJEK */
function lemparObjek() {
  if (gameOver) return;

  const obj = document.createElement("div");
  obj.className = "objek";

  const isBom = Math.random() < 0.25;
  obj.classList.add(isBom ? "bom" : "buah");
  if (isBom) obj.innerText = "b";

  arena.appendChild(obj);

  const ukuran = 56; // 🍉 BUAH BESAR
  let x = Math.random() * (arena.clientWidth - ukuran);
  let y = arena.clientHeight;

  let speedY = -(32 + Math.random() * 16 + level * 3);
  let speedX = (Math.random() - 0.5) * 3;

  obj.style.left = x + "px";
  obj.style.top = y + "px";

  const gerak = setInterval(() => {
    speedY += gravity;
    y += speedY;
    x += speedX;

    if (y < 0) {
      y = 0;
      speedY = 0;
    }

    obj.style.top = y + "px";
    obj.style.left = x + "px";

    if (y > arena.clientHeight) {
      clearInterval(gerak);
      obj.remove();
    }
  }, 20);

  obj.onclick = () => {
    clearInterval(gerak);
    obj.remove();

    if (isBom) {
      soundBomb.play();
      efekBom(x, y);
      nyawa--;
      nyawaText.innerText = nyawa;

      if (nyawa <= 0) {
        gameOver = true;
        cekHighScore();
        setTimeout(() => {
          alert("💣 GAME OVER\nSkor: " + skor);
          location.reload();
        }, 300);
      }
    } else {
      soundSlice.play();
      efekBelah(x, y);
      skor++;
      skorText.innerText = skor;
      cekHighScore();

      if (skor % 10 === 0 && level < 5) {
        level++;
        levelText.innerText = level;
      }
    }
  };
}

/* AUTO SPAWN */
setInterval(lemparObjek, 900);
