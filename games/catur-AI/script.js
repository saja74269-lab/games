const board = document.getElementById("board");
const info = document.getElementById("info");
const deadWhite = document.getElementById("deadWhite");
const deadBlack = document.getElementById("deadBlack");

const pieces = {
    r:"♜", n:"♞", b:"♝", q:"♛", k:"♚", p:"♟",
    R:"♖", N:"♘", B:"♗", Q:"♕", K:"♔", P:"♙"
};

let game = [
    "rnbqkbnr",
    "pppppppp",
    "........",
    "........",
    "........",
    "........",
    "PPPPPPPP",
    "RNBQKBNR"
];

let selected = null;
let highlights = [];
let turn = "white";

const isWhite = p => p === p.toUpperCase();
const inBoard = (r,c)=> r>=0 && r<8 && c>=0 && c<8;

/* ================= DRAW ================= */
function draw(){
    board.innerHTML="";
    for(let r=0;r<8;r++){
        for(let c=0;c<8;c++){
            const cell=document.createElement("div");
            cell.className="cell "+((r+c)%2?"dark":"light");

            if(highlights.some(h=>h.r===r && h.c===c))
                cell.classList.add("highlight");

            if(selected && selected.r===r && selected.c===c)
                cell.classList.add("selected");

            let p=game[r][c];
            if(p!=".") cell.textContent=pieces[p];

            cell.onclick=()=>clickCell(r,c);
            board.appendChild(cell);
        }
    }
    info.textContent="Giliran: "+(turn==="white"?"PUTIH":"HITAM");
}

/* ================= CLICK ================= */
function clickCell(r,c){
    let p = game[r][c];

    if(selected){
        let from = game[selected.r][selected.c];

        // ganti pilihan kalau klik bidak sendiri
        if(p !== "." && isWhite(p) === isWhite(from)){
            selected = {r,c};
            highlights = getMoves(r,c);
            draw();
            return;
        }

        // pindah kalau valid
        if(highlights.some(h=>h.r===r && h.c===c)){
            move(selected.r,selected.c,r,c);
            turn = turn==="white"?"black":"white";

            if(isInCheck(turn)){
                info.textContent="SKAK!";
                if(isCheckmate(turn)){
                    info.textContent="SKAKMAT! "+(turn==="white"?"HITAM":"PUTIH")+" MENANG";
                }
            }

            selected=null;
            highlights=[];
            draw();

            if(turn==="black"){
                setTimeout(aiMove,400);
            }
            return;
        }

        // klik kosong / salah → batal
        selected=null;
        highlights=[];
        draw();
        return;
    }

    // pilih bidak sesuai giliran
    if(p!="." && ((turn==="white" && isWhite(p)) || (turn==="black" && !isWhite(p)))){
        selected={r,c};
        highlights=getMoves(r,c);
        draw();
    }
}

/* ================= MOVE ================= */
function move(r1,c1,r2,c2){
    let from = game[r1][c1];
    let to   = game[r2][c2];

    // cegah makan bidak sendiri
    if(to!=="." && isWhite(from)===isWhite(to)) return;

    if(to!=="."){
        let dead=pieces[to];
        isWhite(to)? deadWhite.innerHTML+=" "+dead : deadBlack.innerHTML+=" "+dead;
    }

    let a=game[r1].split("");
    let b=game[r2].split("");
    b[c2]=a[c1];
    a[c1]=".";
    game[r1]=a.join("");
    game[r2]=b.join("");
}

/* ================= MOVES ================= */
function getMoves(r,c){
    const p=game[r][c];
    let moves=[];
    let dir=isWhite(p)?-1:1;

    const add=(rr,cc)=>{
        if(!inBoard(rr,cc)) return;
        let t=game[rr][cc];
        if(t==="." || isWhite(t)!==isWhite(p))
            moves.push({r:rr,c:cc});
    };

    // pawn
    if(p.toLowerCase()==="p"){
        if(inBoard(r+dir,c) && game[r+dir][c]===".")
            moves.push({r:r+dir,c});
        for(let dc of [-1,1]){
            if(inBoard(r+dir,c+dc)){
                let t=game[r+dir][c+dc];
                if(t!="." && isWhite(t)!==isWhite(p))
                    moves.push({r:r+dir,c:c+dc});
            }
        }
    }

    // rook + queen
    if("rRqQ".includes(p)){
        [[1,0],[-1,0],[0,1],[0,-1]].forEach(d=>{
            let rr=r+d[0], cc=c+d[1];
            while(inBoard(rr,cc)){
                if(game[rr][cc]===".") add(rr,cc);
                else{
                    if(isWhite(game[rr][cc])!==isWhite(p)) add(rr,cc);
                    break;
                }
                rr+=d[0]; cc+=d[1];
            }
        });
    }

    // bishop + queen
    if("bBqQ".includes(p)){
        [[1,1],[1,-1],[-1,1],[-1,-1]].forEach(d=>{
            let rr=r+d[0], cc=c+d[1];
            while(inBoard(rr,cc)){
                if(game[rr][cc]===".") add(rr,cc);
                else{
                    if(isWhite(game[rr][cc])!==isWhite(p)) add(rr,cc);
                    break;
                }
                rr+=d[0]; cc+=d[1];
            }
        });
    }

    // knight
    if(p.toLowerCase()==="n"){
        [[2,1],[2,-1],[-2,1],[-2,-1],[1,2],[1,-2],[-1,2],[-1,-2]]
        .forEach(d=>add(r+d[0],c+d[1]));
    }

    // king
    if(p.toLowerCase()==="k"){
        for(let dr=-1;dr<=1;dr++)
            for(let dc=-1;dc<=1;dc++)
                if(dr||dc) add(r+dr,c+dc);
    }

    return moves;
}

/* ================= CHECK ================= */
function findKing(color){
    for(let r=0;r<8;r++)
        for(let c=0;c<8;c++){
            let p=game[r][c];
            if(p!="." && p.toLowerCase()==="k"){
                if(color==="white" && isWhite(p)) return {r,c};
                if(color==="black" && !isWhite(p)) return {r,c};
            }
        }
}

function isInCheck(color){
    let k=findKing(color);
    for(let r=0;r<8;r++)
        for(let c=0;c<8;c++){
            let p=game[r][c];
            if(p==="." || isWhite(p)===(color==="white")) continue;
            if(getMoves(r,c).some(m=>m.r===k.r && m.c===k.c))
                return true;
        }
    return false;
}

function isCheckmate(color){
    if(!isInCheck(color)) return false;
    for(let r=0;r<8;r++)
        for(let c=0;c<8;c++){
            let p=game[r][c];
            if(p==="." || isWhite(p)!==(color==="white")) continue;
            for(let m of getMoves(r,c)){
                let backup=game.map(x=>x);
                move(r,c,m.r,m.c);
                let ok=!isInCheck(color);
                game=backup;
                if(ok) return false;
            }
        }
    return true;
}

/* ================= AI ================= */
function aiMove(){
    if(turn!=="black") return;
    let list=[];
    for(let r=0;r<8;r++)
        for(let c=0;c<8;c++){
            let p=game[r][c];
            if(p==="."||isWhite(p)) continue;
            for(let m of getMoves(r,c))
                list.push({r1:r,c1:c,r2:m.r,c2:m.c});
        }
    if(list.length===0) return;
    let m=list[Math.floor(Math.random()*list.length)];
    move(m.r1,m.c1,m.r2,m.c2);
    turn="white";
    draw();
}

draw();
