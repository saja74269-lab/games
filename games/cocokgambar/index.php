<?php
session_start();

$level = $_GET['level'] ?? 1;
$level = max(1, min(5, $level));

$levelConfig = [
    1 => ['pairs'=>3, 'time'=>60],
    2 => ['pairs'=>4, 'time'=>60],
    3 => ['pairs'=>6, 'time'=>90],
    4 => ['pairs'=>8, 'time'=>120],
    5 => ['pairs'=>10,'time'=>150],
];

$pairs = $levelConfig[$level]['pairs'];
$timeLimit = $levelConfig[$level]['time'];

$images = range(1,10);
shuffle($images);
$selected = array_slice($images,0,$pairs);

$cards = array_merge($selected,$selected);
shuffle($cards);
?>

<!DOCTYPE html>
<html>
<head>
<title>IT Memory Game</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    background:#0b1c2d;
    font-family:Arial;
    color:white;
    text-align:center;
    margin:0;
}
header{
    background:#122c44;
    padding:15px;
}
.game{
    max-width:700px;
    margin:auto;
    padding:20px;
}
.board{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:15px;
}
.card{
    aspect-ratio:1/1;
    perspective:1000px;
}
.inner{
    width:100%;
    height:100%;
    transition:.5s;
    transform-style:preserve-3d;
    cursor:pointer;
    position:relative;
}
.card.flip .inner{transform:rotateY(180deg);}
.front,.back{
    position:absolute;
    width:100%;
    height:100%;
    backface-visibility:hidden;
    border-radius:12px;
}
.front{
    transform:rotateY(180deg);
    background:white;
}
.front img{
    width:100%;
    height:100%;
    object-fit:contain;
}
.back{
    background:#1abc9c;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
}
.info{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}
@media(max-width:600px){
    .board{grid-template-columns:repeat(3,1fr);}
}
</style>
</head>

<body>
<header>
<h2>IT Memory Match Game</h2>
Level: <?= $level ?> | Target: <?= $pairs ?> Pasang
</header>

<div class="game">
<div class="info">
<div>Skor: <span id="score">0</span></div>
<div>Waktu: <span id="time"><?= $timeLimit ?></span>s</div>
</div>

<div class="board">
<?php foreach($cards as $i=>$v): ?>
<div class="card" data-value="<?= $v ?>">
    <div class="inner">
        <div class="front"><img src="assets/img/<?= $v ?>.png"></div>
        <div class="back">IT</div>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

<script>
let first=null, lock=false, score=0, match=0;
let totalPairs = <?= $pairs ?>;

let time = <?= $timeLimit ?>;
let timer = setInterval(()=>{
    time--;
    document.getElementById("time").innerText = time;
    if(time<=0){
        clearInterval(timer);
        alert("Waktu habis!");
        location.reload();
    }
},1000);

document.querySelectorAll(".card").forEach(card=>{
card.onclick=()=>{
    if(lock || card.classList.contains("matched")) return;

    card.classList.add("flip");
    if(!first){
        first=card;
    }else{
        lock=true;
        if(first.dataset.value === card.dataset.value){
            first.classList.add("matched");
            card.classList.add("matched");
            score += 10 * <?= $level ?>;
            match++;
            document.getElementById("score").innerText=score;
            reset();
            if(match==totalPairs){
                clearInterval(timer);
                setTimeout(()=>{
                    if(<?= $level ?> < 5){
                        location.href="?level=<?= $level+1 ?>";
                    }else{
                        alert("Anda menyelesaikan semua level!");
                        location.href="?level=1";
                    }
                },800);
            }
        }else{
            setTimeout(()=>{
                first.classList.remove("flip");
                card.classList.remove("flip");
                reset();
            },700);
        }
    }
}
});

function reset(){
    first=null;
    lock=false;
}
</script>

</body>
</html>
