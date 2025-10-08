package game

import (
	"encoding/json"
	"fmt"
	"net/http"
)

type Game struct {
	Board         [][]string `json:"board"`
	CurrentPlayer string     `json:"currentPlayer"`
	Winner        string     `json:"winner,omitempty"`
}

var game Game

// Initialiser le plateau
func InitGame(rows, cols int) {
	game = Game{
		Board:         makeBoard(rows, cols),
		CurrentPlayer: "Paris",
	}
}

// Création du plateau vide
func makeBoard(rows, cols int) [][]string {
	board := make([][]string, rows)
	for i := range board {
		board[i] = make([]string, cols)
	}
	return board
}

// Jouer un coup dans la colonne
func Play(col int) {
	for i := len(game.Board) - 1; i >= 0; i-- {
		if game.Board[i][col] == "" {
			game.Board[i][col] = game.CurrentPlayer
			break
		}
	}
	game.Winner = CheckWinner()
	if game.Winner == "" {
		if game.CurrentPlayer == "Paris" {
			game.CurrentPlayer = "Barcelone"
		} else {
			game.CurrentPlayer = "Paris"
		}
	}
}

// Vérifier le gagnant
func CheckWinner() string {
	rows := len(game.Board)
	cols := len(game.Board[0])
	for r := 0; r < rows; r++ {
		for c := 0; c < cols; c++ {
			p := game.Board[r][c]
			if p == "" {
				continue
			}
			// Horizontal
			if c+3 < cols &&
				game.Board[r][c+1] == p &&
				game.Board[r][c+2] == p &&
				game.Board[r][c+3] == p {
				return p
			}
			// Vertical
			if r+3 < rows &&
				game.Board[r+1][c] == p &&
				game.Board[r+2][c] == p &&
				game.Board[r+3][c] == p {
				return p
			}
			// Diagonale droite-bas
			if r+3 < rows && c+3 < cols &&
				game.Board[r+1][c+1] == p &&
				game.Board[r+2][c+2] == p &&
				game.Board[r+3][c+3] == p {
				return p
			}
			// Diagonale gauche-bas
			if r+3 < rows && c-3 >= 0 &&
				game.Board[r+1][c-1] == p &&
				game.Board[r+2][c-2] == p &&
				game.Board[r+3][c-3] == p {
				return p
			}
		}
	}
	return ""
}

// Réinitialiser la partie
func ResetGame() {
	rows := len(game.Board)
	cols := len(game.Board[0])
	InitGame(rows, cols)
}

// Handlers HTTP
func ServeGameHandlers() {
	http.HandleFunc("/board", func(w http.ResponseWriter, r *http.Request) {
		json.NewEncoder(w).Encode(game)
	})

	http.HandleFunc("/play", func(w http.ResponseWriter, r *http.Request) {
		colStr := r.URL.Query().Get("col")
		if colStr == "" {
			http.Error(w, "Colonne manquante", http.StatusBadRequest)
			return
		}
		col := 0
		_, err := fmt.Sscanf(colStr, "%d", &col)
		if err != nil {
			http.Error(w, "Colonne invalide", http.StatusBadRequest)
			return
		}
		Play(col)
		json.NewEncoder(w).Encode(game)
	})

	http.HandleFunc("/reset", func(w http.ResponseWriter, r *http.Request) {
		ResetGame()
		json.NewEncoder(w).Encode(game)
	})
}