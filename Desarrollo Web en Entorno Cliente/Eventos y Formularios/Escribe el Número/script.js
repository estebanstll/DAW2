let score = 0;
let lives = 3;
let currentNumber = "";
let intervalTime = 3000;
let numberInterval;

const numberBox = document.getElementById("number-box");
const inputNumber = document.getElementById("input-number");
const scoreSpan = document.getElementById("score");
const livesSpan = document.getElementById("lives");
const startBtn = document.getElementById("start-btn");

const gameOverDiv = document.getElementById("game-over");
const finalScoreSpan = document.getElementById("final-score");
const bestScoreSpan = document.getElementById("best-score");
const restartBtn = document.getElementById("restart-btn");

startBtn.addEventListener("click", startGame);
restartBtn.addEventListener("click", () => location.reload());

inputNumber.addEventListener("keydown", (e) => {
  if (e.key === "Enter") validateNumber();
});

function startGame() {
  startBtn.style.display = "none";
  generateNumber();
  numberInterval = setInterval(generateNumber, intervalTime);
}

function generateNumber() {
  currentNumber = Math.floor(Math.random() * (999 - 100 + 1)) + 100;
  numberBox.textContent = currentNumber;

  setTimeout(() => {
    numberBox.textContent = "";
  }, 500);
}

function validateNumber() {
  if (inputNumber.value == currentNumber) {
    score++;
    scoreSpan.textContent = score;

    if (score % 5 === 0 && intervalTime > 1000) {
      clearInterval(numberInterval);
      intervalTime -= 300;
      numberInterval = setInterval(generateNumber, intervalTime);
    }
  } else {
    lives--;
    livesSpan.textContent = lives;

    if (lives <= 0) return endGame();
  }

  inputNumber.value = "";
}

function endGame() {
  clearInterval(numberInterval);

  finalScoreSpan.textContent = score;

  let best = localStorage.getItem("bestNumberScore");
  if (!best || score > best) {
    best = score;
    localStorage.setItem("bestNumberScore", best);
  }

  bestScoreSpan.textContent = best;

  document.getElementById("game-container").style.display = "none";
  gameOverDiv.classList.remove("hidden");
}
