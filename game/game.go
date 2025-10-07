package game

import (
	"strings"
)

const (
	Rows = 6
	Cols = 7
)

type Game struct {
	Board  [Rows][Cols]string
	Player string
	Winner string
}

// Crée une nouvelle partie
func NewGame() *Game {
	g := &Game{Player: "Paris"}
	for r := 0; r < Rows; r++ {
		for c := 0; c < Cols; c++ {
			g.Board[r][c] = "."
		}
	}
	return g
}

// Joue un jeton dans la colonne
func (g *Game) DropDisc(col int) bool {
	if col < 0 || col >= Cols || g.Winner != "" {
		return false
	}

	// Descendre jusqu'à la première cellule vide
	for r := Rows - 1; r >= 0; r-- {
		if g.Board[r][col] == "." {
			g.Board[r][col] = g.Player
			g.checkWinner(r, col)
			g.switchPlayer()
			return true
		}
	}
	return false
}

// Change le joueur courant
func (g *Game) switchPlayer() {
	if g.Player == "Paris" {
		g.Player = "Barcelone"
	} else {
		g.Player = "Paris"
	}
}

// Renvoie le plateau sous forme de texte
func (g *Game) BoardText() string {
	var sb strings.Builder
	for r := 0; r < Rows; r++ {
		for c := 0; c < Cols; c++ {
			sb.WriteString(g.Board[r][c])
			if c < Cols-1 {
				sb.WriteString(" ")
			}
		}
		sb.WriteString("\n")
	}

	if g.Winner != "" {
		sb.WriteString("Winner: " + g.Winner + "\n")
	} else {
		sb.WriteString("CurrentPlayer: " + g.Player + "\n")
	}

	return sb.String()
}

// Vérifie si le dernier coup a créé un alignement de 4
func (g *Game) checkWinner(row, col int) {
	directions := [][2]int{
		{0, 1},  // horizontal
		{1, 0},  // vertical
		{1, 1},  // diagonale \
		{1, -1}, // diagonale /
	}

	player := g.Board[row][col]

	for _, d := range directions {
		count := 1

		// Vérifier dans la direction positive
		for i := 1; i < 4; i++ {
			r := row + i*d[0]
			c := col + i*d[1]
			if r < 0 || r >= Rows || c < 0 || c >= Cols || g.Board[r][c] != player {
				break
			}
			count++
		}

		// Vérifier dans la direction négative
		for i := 1; i < 4; i++ {
			r := row - i*d[0]
			c := col - i*d[1]
			if r < 0 || r >= Rows || c < 0 || c >= Cols || g.Board[r][c] != player {
				break
			}
			count++
		}

		if count >= 4 {
			g.Winner = player
			return
		}
	}
}
