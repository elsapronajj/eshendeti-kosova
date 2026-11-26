# eShëndeti Kosova

Sistem kombëtar për shkëmbimin e të dhënave shëndetësore të pacientëve ndërmjet institucioneve shëndetësore në Kosovë.

Projekt në lëndën **Dizajni i Sistemit të Softuerit**, Kolegji UBT, 2026.

## Përshkrimi i projektit

eShëndeti Kosova është një projekt full-stack studentor, i ndërtuar me Laravel REST API në backend dhe React në frontend.

Sistemi implementohet në të gjitha spitalet dhe QKMF-të e Kosovës. Çdo pacient regjistrohet një herë me numrin personal dhe ka një dosje shëndetësore të vetme kombëtare. Në cilindo institucion që paraqitet, mjeku i autorizuar mund të shohë:

- në cilat spitale dhe QKMF ka qenë pacienti;
- çfarë kontrollesh ka kryer;
- cilat diagnoza i janë vendosur dhe cila është gjendja e tij;
- çfarë terapie merr;
- si i kanë dalë analizat laboratorike.

Pacienti vendos cilat institucione kanë qasje në dosjen e tij, dhe çdo hapje e dosjes regjistrohet. Ideja mbështetet në dosjen elektronike të pacientit që përdoret në Zvicër.

## Problemi

Institucionet shëndetësore në Kosovë nuk kanë një sistem të përbashkët për të dhënat e pacientëve. Kur pacienti shkon në një institucion tjetër, mjeku nuk e di historikun e tij, ndaj kontrollet dhe analizat shpesh përsëriten, kurse informacione kritike, si alergjitë ose terapia aktuale, mund të mungojnë në urgjencë.

## Ekipi dhe përgjegjësitë

| Anëtari | Moduli | Paketat / klasat |
|---|---|---|
| Elsa Pronaj | Historiku klinik | `backend/app/Presentation/HistorikuKlinik`, `backend/app/Business/HistorikuKlinik`, `backend/app/Data/HistorikuKlinik`, `frontend/src/modules/historiku-klinik` |
| Olta Mucolli | Analizat laboratorike | `backend/app/Presentation/Analizat`, `backend/app/Business/Analizat`, `backend/app/Data/Analizat`, `frontend/src/modules/analizat` |
| Julinde Rexhepi | Autorizimet dhe qasja | `backend/app/Presentation/Autorizimet`, `backend/app/Business/Autorizimet`, `backend/app/Data/Autorizimet`, `frontend/src/modules/autorizimet` |
| I gjithë grupi | Puna e përbashkët | Modeli konceptual, skeleti i arkitekturës, autentifikimi, `backend/app/Data/Shared`, seeder-at, `frontend/src/components` |

> Tabela përditësohet me klasat konkrete pas përfundimit të dokumentit të dizajnit të detajuar (DDD).

## Funksionalitetet kryesore

### Historiku klinik
- Kërkimi i pacientit me numrin personal nga cilido institucion
- Historiku kohor i vizitave nëpër të gjitha institucionet
- Regjistrimi i vizitës: lloji (urgjencë, kontroll, shtrim), arsyeja, përshkrimi
- Diagnozat me kod ICD dhe status (aktive / jo aktive)
- Terapitë aktuale dhe të mëparshme
- Alergjitë e pacientit, të shfaqura qartë në krye të dosjes
- Përmbledhja e gjendjes: diagnozat aktive dhe terapia aktuale

### Analizat laboratorike
- Kërkimi i analizave gjatë një vizite
- Regjistrimi i rezultateve me njësi dhe kufij referentë
- Shënimi automatik i rezultateve jashtë kufijve referentë
- Njoftimi i mjekut kur një rezultat del jashtë kufijve
- Historiku i rezultateve për të njëjtën analizë (p.sh. glukoza nëpër kohë)

### Autorizimet dhe qasja
- Pacienti autorizon ose tërheq qasjen për një institucion
- Afati i autorizimit dhe lloji (i përhershëm / i përkohshëm)
- Kontrolli nëse mjeku ka qasje para hapjes së dosjes
- Qasja emergjente me arsye të detyrueshme
- Regjistri i qasjeve: kush e hapi dosjen, kur, pse
- Pacienti e sheh vetë regjistrin e qasjeve në dosjen e tij

### Të përbashkëta
- Regjistrimi dhe hyrja me JWT Access Token
- Refresh Token në cookie HttpOnly
- Rolet: pacient, mjek, administrator
- Rrugët e mbrojtura në backend dhe frontend
- Menaxhimi i institucioneve (spitale dhe QKMF) nga administratori

## Teknologjitë

### Backend

- Laravel (PHP), REST API
- Eloquent ORM
- MySQL
- Laravel migrations dhe seeders
- Form Request validation
- API Resources
- JWT Access Token service
- Refresh Tokens të ruajtur në bazë
- Middleware për JWT dhe role

### Frontend

- React
- Vite
- React Router
- Axios me interceptors për token
- React Context API për gjendjen e autentifikimit
- Komponenti i rrugëve të mbrojtura

## Arkitektura

### Stili arkitekturor

Sistemi përdor **stilin shtresor (layered)**. Çdo shtresë thërret vetëm shtresën poshtë saj:

```text
Prezantimi          -> faqet React dhe kontrollerët e API-së
   ↓
Logjika e biznesit  -> shërbimet e moduleve dhe rregullat e biznesit
   ↓
Qasja në të dhëna   -> modelet Eloquent dhe repozitorët
```

Çdo modul kalon nëpër të tria shtresat. Çdo anëtar shkruan klasat e modulit të vet në secilën shtresë.

### Bashkëpunimi ndërmjet moduleve

Modulet nuk janë aplikacione të ndara. Ato komunikojnë përmes shërbimeve të shtresës së logjikës së biznesit:

| Moduli | Ofron | Kërkon |
|---|---|---|
| Autorizimet dhe qasja | `kaQasje(mjeku, pacienti)`, `regjistroQasjen(...)`, `qasjeEmergjente(...)` | – |
| Historiku klinik | `merrHistorikun(pacienti)`, `merrVizitën(id)` | `Autorizimet.kaQasje()`, `Autorizimet.regjistroQasjen()`, `Analizat.merrAnalizatEVizitës()` |
| Analizat laboratorike | `merrAnalizatEVizitës(vizita)`, `regjistroRezultatin(...)` | `HistorikuKlinik.merrVizitën()`, `Autorizimet.kaQasje()` |

Shembull: kur mjeku hap dosjen, `HistorikuKlinik` pyet `Autorizimet` nëse ka qasje, regjistron qasjen dhe merr analizat nga `Analizat` për t'i shfaqur në historik.

### Design patterns

| Pattern | Ku përdoret | Pse |
|---|---|---|
| **Facade** | Një klasë shërbimi për çdo modul (`HistorikuKlinikService`, `AnalizatService`, `AutorizimetService`) | Modulet e tjera përdorin vetëm këtë klasë dhe nuk varen nga detajet e brendshme |
| **Observer** | Kur regjistrohet një rezultat analize jashtë kufijve | Njoftohet mjeku pa e lidhur modulin e analizave drejtpërdrejt me njoftimet |
| **Strategy** | Rregullat e qasjes: qasje e zakonshme dhe qasje emergjente | Rregullat e ndryshme të qasjes ndërrohen pa ndryshuar pjesën tjetër të modulit |

> Dy pattern-at e para janë minimumi i kërkuar; Strategy është opsional.

## Struktura e projektit

```text
/backend   -> Laravel REST API
/frontend  -> React Vite application
/diagramet -> modeli konceptual, SAD-i dhe diagramet
```

Backend:

```text
backend/app/
├── Presentation/                 -> kontrollerët e API-së, sipas modulit
│   ├── HistorikuKlinik/
│   ├── Analizat/
│   └── Autorizimet/
├── Business/                     -> shërbimet (Facade) dhe rregullat e biznesit
│   ├── HistorikuKlinik/
│   ├── Analizat/
│   └── Autorizimet/
├── Data/                         -> modelet Eloquent
│   ├── Shared/                   -> Pacienti, Institucioni, Mjeku
│   ├── HistorikuKlinik/          -> Dosja, Alergjia, Vizita, Diagnoza, Terapia
│   ├── Analizat/                 -> Analiza
│   └── Autorizimet/              -> Autorizimi, Qasja
└── Models/User.php               -> përdoruesi për autentifikim
backend/routes/api.php            -> rrugët e API-së
backend/database/migrations       -> skema e bazës së të dhënave
backend/database/seeders          -> të dhëna testimi (InstitucioniSeeder, MjekuSeeder)
```
Rregulli i varësive: `Presentation` thërret vetëm `Business`, dhe `Business` thërret vetëm `Data`. Klasat e modelit konceptual(`Pacienti`, `Dosja`, `Vizita` ...) përdoren vetëm në `Business` dhe `Data`; shtresa `Presentation` merr nga `Business` vetëm të dhëna të përgaditura (DTO).


Frontend:

```text
frontend/src/
├── components/
│   └── Layout.jsx                -> koka, menyja dhe fundi i përbashkët
├── pages/
│   ├── Ballina.jsx               -> faqja hyrëse
│   ├── Login.jsx                 -> hyrja
│   └── NukUGjet.jsx              -> faqja 404
├── modules/                      -> faqet e moduleve (në vijim)
│   ├── historiku-klinik/
│   ├── analizat/
│   └── autorizimet/
├── App.jsx                       -> rrugët (React Router)
└── main.jsx


## Modeli konceptual

Diagrami i modelit konceptual ndodhet në `diagramet/ModeliKonceptual-eShendeti.drawio.png`.

### Klasat

- `Pacienti`
- `DosjaShendetesore`
- `Vizita`
- `Diagnoza`
- `Terapia`
- `Alergjia`
- `Analiza`
- `Autorizimi`
- `Qasja`
- `Mjeku`
- `Institucioni` (abstrakte)
- `Spitali`
- `QKMF`

### Marrëdhëniet

- Një pacient ka një dosje shëndetësore.
- Dosja përmban shumë vizita (agregim).
- Dosja regjistron shumë alergji.
- Një vizitë kryhet në një institucion nga një mjek.
- Një vizitë përcakton shumë diagnoza, përshkruan shumë terapi dhe kërkon shumë analiza.
- Një mjek punon në një ose më shumë institucione.
- Një pacient jep shumë autorizime; çdo autorizim i jepet një institucioni.
- Një mjek kryen shumë qasje; çdo qasje i përket një dosjeje.
- Spitali dhe QKMF janë lloje të institucionit (trashëgimi).

## Tabelat e bazës së të dhënave 

| Tabela | Moduli | Fushat |
|---|---|---|
| `pacientet` | E përbashkët | `id`, `numri_personal`, `emri`, `mbiemri`, `data_e_lindjes`, `gjinia`, `grupi_gjakut`, `telefoni` |
| `institucionet` | E përbashkët | `id`, `kodi`, `emri`, `qyteti`, `telefoni`, `lloji` (spital / qkmf), `numri_shtreterve`, `komuna` |
| `mjeket` | E përbashkët | `id`, `numri_i_licences`, `titulli`, `emri`, `mbiemri`, `specializimi`, `statusi_i_licences` |
| `dosjet` | Historiku klinik | `id`, `pacient_id`, `data_e_krijimit`, `data_e_perditesimit` |
| `alergjite` | Historiku klinik | `id`, `dosje_id`, `substanca`, `ashpersia` |
| `vizitat` | Historiku klinik | `id`, `dosje_id`, `mjek_id`, `institucion_id`, `data`, `lloji`, `arsyeja`, `pershkrimi` |
| `diagnozat` | Historiku klinik | `id`, `vizite_id`, `kodi`, `pershkrimi`, `data`, `statusi` |
| `terapite` | Historiku klinik | `id`, `vizite_id`, `medikamenti`, `dozimi`, `data_e_fillimit`, `data_e_perfundimit` |
| `analizat` | Analizat | `id`, `vizite_id`, `lloji`, `rezultati`, `njesia`, `kufiri_i_poshtem`, `kufiri_i_siperm`, `data`, `statusi` |
| `mjek_institucion` | Autorizimet | `id`, `mjek_id`, `institucion_id` |
| `autorizimet` | Autorizimet | `id`, `pacient_id`, `institucion_id`, `lloji`, `data_e_fillimit`, `data_e_skadimit`, `statusi` |
| `qasjet` | Autorizimet | `id`, `dosje_id`, `mjek_id`, `data_ora`, `arsyeja`, `eshte_emergjente` |
| `users` | Autentifikimi | përdoruesit (rolet dhe refresh token-at shtohen me autentifikimin) |

> Spitali dhe QKMF ruhen në një tabelë (`institucionet`) me fushën `lloji` (single-table inheritance).

## Autentifikimi

Autentifikimi është punë e përbashkët e grupit dhe nuk llogaritet si modul.

1. Përdoruesi hyn me email dhe fjalëkalim.
2. Laravel kthen një JWT Access Token me jetëgjatësi të shkurtër.
3. Laravel krijon një Refresh Token, ruan hash-in e tij në bazë dhe e dërgon në cookie HttpOnly.
4. React e mban Access Token-in vetëm në memorie.
5. Axios e dërgon token-in me çdo kërkesë të mbrojtur:

```http
Authorization: Bearer <token>
```

6. Nëse kërkesa kthen `401`, Axios thërret `/api/refresh-token` dhe e përsërit kërkesën.
7. Logout e anulon Refresh Token-in dhe e fshin cookie-n.

## API Endpoints (planifikuar)

### Autentifikimi

```http
POST /api/register
POST /api/login
POST /api/refresh-token
POST /api/logout
GET  /api/me
```

### Historiku klinik

```http
GET  /api/pacientet/{numriPersonal}/dosja
GET  /api/pacientet/{numriPersonal}/vizitat
POST /api/vizitat
GET  /api/vizitat/{id}
POST /api/vizitat/{id}/diagnozat
POST /api/vizitat/{id}/terapite
POST /api/pacientet/{numriPersonal}/alergjite
```

### Analizat laboratorike

```http
POST /api/vizitat/{id}/analizat
PUT  /api/analizat/{id}/rezultati
GET  /api/pacientet/{numriPersonal}/analizat
GET  /api/analizat/jashte-kufijve
```

### Autorizimet dhe qasja

```http
GET    /api/autorizimet
POST   /api/autorizimet
DELETE /api/autorizimet/{id}
POST   /api/qasja-emergjente
GET    /api/pacientet/{numriPersonal}/qasjet
```

### Administrimi

```http
GET  /api/institucionet
POST /api/institucionet
```

## Rrugët e frontend-it (planifikuar)

| Rruga | Roli | Përshkrimi |
|---|---|---|
| `/` | Publik | Faqja hyrëse |
| `/login` | Publik | Hyrja |
| `/mjeku/kerko` | Mjek | Kërkimi i pacientit me numrin personal |
| `/mjeku/pacienti/:numriPersonal` | Mjek | Dosja: historiku, diagnozat, terapitë, analizat |
| `/pacienti/dosja` | Pacient | Dosja ime |
| `/pacienti/autorizimet` | Pacient | Menaxhimi i autorizimeve |
| `/pacienti/qasjet` | Pacient | Kush e ka parë dosjen time |
| `/admin/institucionet` | Administrator | Institucionet e lidhura |

## Dokumentet e projektit

| Kërkesa | Dokumenti | Skedari | Statusi |
|---|---|---|---|
| 1 | Modeli konceptual | `diagramet/ModeliKonceptual-eShendeti.drawio.png` | Diagrami gati; përshkrimi me tekst në punë |
| 2 | Dokumenti i arkitekturës (SAD) | `diagramet/Dokumenti i arkitekturës së softuerit (SAD).docx` | Gati |
| 3 | Dokumenti i dizajnit të detajuar (DDD) | – | Në vijim |
| – | Diagramet e sekuencës | te SAD-i | Gati |

## Instalimi dhe ekzekutimi

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Konfiguro bazën e të dhënave në `backend/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eshendeti
DB_USERNAME=root
DB_PASSWORD=
```

Ekzekuto migrimet dhe të dhënat demonstrative:

```bash
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8011
```

### Frontend

```bash
cd frontend
npm install
```

Konfiguro `frontend/.env`:

```env
VITE_API_BASE_URL=http://127.0.0.1:8011/api
```

Ekzekuto:

```bash
npm run dev -- --host 127.0.0.1 --port 5174
```

Hape në shfletues:

```text
http://127.0.0.1:5174/
```

### Variablat e rëndësishme të backend-it

```env
JWT_SECRET=
JWT_ACCESS_TTL_MINUTES=15
JWT_REFRESH_TTL_DAYS=14
JWT_REFRESH_COOKIE=eshendeti_refresh_token
CORS_ALLOWED_ORIGINS=http://127.0.0.1:5174,http://localhost:5174
```

> Skedari `.env` nuk ngarkohet kurrë në GitHub. Në repozitor ruhet vetëm `.env.example`.

## Testimi

```bash
cd backend
php artisan test
```

```bash
cd frontend
npm run lint
npm run build
```

## Rregullat e punës në Git

- Repozitori është publik.
- Çdo anëtar bën commit me llogarinë e vet, për modulin e vet, gjatë gjithë punës, jo vetëm në fund.
- Puna e përbashkët (modeli konceptual, skeleti, autentifikimi, konfigurimi) ndahet në commit-e mes anëtarëve.
- Mesazhet e commit-eve përshkruajnë shkurt ndryshimin, p.sh. `Modeli Analiza` ose `Tabela vizitat`.
- Rradha: `git add`, `git commit`, pastaj `git pull --rebase` dhe `git push`.
- Komandat `composer` dhe `php artisan` ekzekutohen te `backend`, ndërsa `npm` te `frontend`.


## Përmirësime të mundshme

- Lidhja me sistemet reale të institucioneve përmes standardit HL7 FHIR
- Njoftime me email ose SMS kur dikush e hap dosjen
- Ngarkimi i dokumenteve (raporte, imazheri)
- Aplikacion mobil për pacientët
- Raporte statistikore për Ministrinë e Shëndetësisë

> Të gjitha të dhënat në sistem janë fiktive dhe përdoren vetëm për qëllime akademike.
