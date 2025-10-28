package start

import (
	"os/exec"
	"runtime"
)

func openURL(url string) {
	switch runtime.GOOS {
	case "windows":
		exec.Command("rundll32", "url.dll,FileProtocolHandler", url).Start()
	case "darwin":
		exec.Command("open", url).Start()
	default: // linux, bsd, etc.
		exec.Command("xdg-open", url).Start()
	}
}

