package main

import (
	"fmt"
	"log"
	"net/http"
	"power4-web/game"
	"strconv"
)

var currentGame *game.Game

func main() {
	// Page d’accueil
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, "./welcome/welcome.html")
	})

	// Démarrer une partie
	http.HandleFunc("/start", func(w http.ResponseWriter, r *http.Request) {
		currentGame = game.NewGame()
		w.Header().Set("Content-Type", "text/plain")
		fmt.Fprint(w, currentGame.BoardText())
	})

	// Jouer un coup
	http.HandleFunc("/play", func(w http.ResponseWriter, r *http.Request) {
		if currentGame == nil {
			http.Error(w, "Aucune partie en cours", http.StatusBadRequest)
			return
		}
		colStr := r.URL.Query().Get("col")
		col, err := strconv.Atoi(colStr)
		if err != nil || !currentGame.DropDisc(col) {
			fmt.Fprint(w, currentGame.BoardText())
			return
		}
		fmt.Fprint(w, currentGame.BoardText())
	})

	http.Handle("/css/", http.StripPrefix("/css/", http.FileServer(http.Dir("./css"))))

	port := ":8080"
	fmt.Printf("Serveur démarré sur http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, nil))
}
