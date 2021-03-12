# Git Cheatsheet - Burim


## Verbinden von lokalen Repository zu den remote Repository

```
echo "# M300_CheatSheet" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:aleksandar6699/M300_CheatSheet.git
git push -u origin main
```


## Abfragen / Troubleshooting

Anzeigen von aktuellen File-Status.

`$ git status`

Datei die ge-staged wurde, aus dem Index entfernen.

`$ git reset HEAD {file}`

Commit History ansehen.

`$ git log`

Remote Repository anzeigen

`$ git remote -v`

Zeigt alles was im Workplace geändert wurde aber noch nicht im Index ist.

`$ git diff`

Zeigt was bereits zum Commit vorgemerkt wurde.

`$ git diff --cached` *(auch --staged)

## Aktionen ausführen

Datei zum Index einfügen.

`$ git add {file}`
>  mit `$ git add .`  *fügen wir __alle__ neuen oder geänderten Files dem Index zu.*

Datei die ge-staged wurde, aus dem Index entfernen.

`$ git reset HEAD {file}`

Die Änderungen im Index in das lokale Repository committen.

`$ git commit {file}`
> *mit dem dem zusätzlichen Parameter* `... commit -m "Kommentar" {file}` *können wir einen Kommentar (Message) hinzufügen.*

Ein im Workplace modifiziertes File wieder auf den Stand des letzter Commit setzen.

`$ git checkout -- {file}`

Alle Änderungen vom remote Repository (origin) in den Workplace laden.

`$ git pull`
> Falls die Files **lokal und remote** geändert, entsteht Konflikt

Änderungen vom lokalen Repository nach remote pushen.

`$ git push origin`
> *vor einem `push` immer zuerst ein `pull` ausführeny*


## Tags

Tags können mit den Snapshots verglichen werden. Sie halten den Zustand zu einem bestimmten Zeitpunkt fest. So können sie jederzeit wieder auf einen Taged Stand ihrer Umgebung zurückgreifen.

> Tagged Versionen sind nicht geeignet um an diesen weiter zu arbeiten. Dazu sieht git *Branches* vor, worauf wir hier nicht weiter eingehen werden.

Vorhandene Tags listen

`$ git tag`

Tag erstellen (Annonated)

`$ git tag -a v1.5 -m "Version 1.7"`
> *-a erstellt einen Annonated (Kommentierte) Tag*

Tag Content ansehen

`$ git tag show v1.7`

Einen spezifischen Tag nach origin pushen

`$ git push origin v1.7`
> `$ git push origin --tags`*alle Tags gleichzeitig pushen*

Lokale Tags löschen

`$ git tag -d v1.7`

Remote Tags löschen

`$ git push origin --delete v1.5`