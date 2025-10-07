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
	// Servir les dossiers statiques
	http.Handle("/power4/", http.StripPrefix("/power4/", http.FileServer(http.Dir("./power4"))))
	http.Handle("/home_page/", http.StripPrefix("/home_page/", http.FileServer(http.Dir("./home_page"))))
	http.Handle("/css/", http.StripPrefix("/css/", http.FileServer(http.Dir("./css"))))

	// Page d’accueil
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, "./home_page/home_page.html")
	})

	// Démarrer une partie
	http.HandleFunc("/start", func(w http.ResponseWriter, r *http.Request) {
		currentGame = game.NewGame()
		w.Header().Set("Content-Type", "text/plain; charset=utf-8")
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
		if err != nil {
			http.Error(w, "Colonne invalide", http.StatusBadRequest)
			return
		}

		if !currentGame.DropDisc(col) {
			http.Error(w, "Coup invalide", http.StatusBadRequest)
			return
		}

		w.Header().Set("Content-Type", "text/plain; charset=utf-8")
		fmt.Fprint(w, currentGame.BoardText())
	})

	// Lancer le serveur
	port := ":8080"
	fmt.Printf("Serveur démarré sur http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, nil))
}
