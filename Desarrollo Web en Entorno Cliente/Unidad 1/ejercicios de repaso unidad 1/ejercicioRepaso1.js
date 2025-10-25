function leetcode(numero, target) {
  // Convertimos el número a string, luego a array de dígitos numéricos
  const nums = numero.toString().split("").map(Number);

  for (let i = 0; i < nums.length; i++) {
    for (let j = i + 1; j < nums.length; j++) {
      if (nums[i] + nums[j] === target) {
        return [i, j];
      }
    }
  }

  return "No se encontró ninguna combinación.";
}

console.log(leetcode(2212, 4));
