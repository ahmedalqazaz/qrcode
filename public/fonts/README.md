Place an Arabic TrueType font here named `arabic.ttf` so PDF export renders Arabic correctly.

Recommended fonts and direct links:
- Amiri (SIL / Open Font License): https://github.com/alif-type/amiri
- Noto Naskh Arabic (Google Fonts, SIL / OFL): https://fonts.google.com/specimen/Noto+Naskh+Arabic

If you are on Windows (PowerShell) you can download Amiri with this command (run in project root):

```powershell
# Download Amiri-Regular.ttf from GitHub raw and save as public/fonts/arabic.ttf
Invoke-WebRequest -Uri "https://github.com/alif-type/amiri/raw/master/Amiri-Regular.ttf" -OutFile "public/fonts/arabic.ttf" -UseBasicParsing
```

If the download fails (network or GitHub blocked), manually download one of the fonts above from your browser and place the TTF at:

	public/fonts/arabic.ttf

After adding the font, you may clear caches and test PDF export from the application.

Example cache-clear commands (PowerShell):

```powershell
php artisan config:clear
php artisan cache:clear
```

License note: Use fonts that are licensed for embedding (Amiri and Noto are open licensed). Always check the font license before distribution.
