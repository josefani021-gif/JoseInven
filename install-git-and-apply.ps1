<#
install-git-and-apply.ps1
Tujuan: Mencoba menginstal Git (via winget) jika tidak ada, lalu menerapkan patch
`replace-agung-josep.patch`. Jika Git tidak tersedia atau `git apply` gagal,
jalankan fallback: cari file di `resources` yang mengandung "Agung",
buat backup `.bak`, lalu ganti semua kemunculan dengan "Josep".
Jalankan script ini dari folder proyek: `.uild\install-git-and-apply.ps1` atau
`Set-Location 'd:\Inven\Inven'; .\install-git-and-apply.ps1`.
#>

function Write-Info($msg){ Write-Host "[INFO] $msg" -ForegroundColor Cyan }
function Write-Warn($msg){ Write-Host "[WARN] $msg" -ForegroundColor Yellow }
function Write-Err($msg){ Write-Host "[ERROR] $msg" -ForegroundColor Red }

# Pastikan dijalankan dari root repo
$cwd = Get-Location
Write-Info "Lokasi kerja: $cwd"

# Cek keberadaan file patch
$patchPath = Join-Path -Path $cwd -ChildPath 'replace-josep.patch'
$hasPatch = Test-Path $patchPath
if ($hasPatch) { Write-Info "Patch ditemukan: $patchPath" } else { Write-Warn "Patch 'replace-josep.patch' tidak ditemukan di root. Skrip akan tetap mencoba fallback replace." }

# Cek Git
$gitCmd = Get-Command git -ErrorAction SilentlyContinue
if (-not $gitCmd) {
    Write-Warn "Git tidak ditemukan di PATH. Mencari winget untuk instalasi otomatis..."
    $winget = Get-Command winget -ErrorAction SilentlyContinue
    if ($winget) {
        Write-Info "Menjalankan: winget install --id Git.Git -e --source winget"
        try {
            winget install --id Git.Git -e --source winget --silent
        } catch {
            Write-Warn "Instalasi via winget gagal atau memerlukan izin. Jalankan installer manual dari https://git-scm.com/download/win"
        }
    } else {
        Write-Warn "Winget tidak tersedia. Silakan instal Git manual dari https://git-scm.com/download/win"
    }
}

# Refresh command lookup
$gitCmd = Get-Command git -ErrorAction SilentlyContinue
if ($gitCmd) {
    Write-Info "Git ditemukan: $($gitCmd.Path)"
    if ($hasPatch) {
        Write-Info "Mencoba menerapkan patch dengan 'git apply'"
        & git apply $patchPath
        if ($LASTEXITCODE -eq 0) {
            Write-Info "Patch diterapkan. Membuat commit..."
            & git add -A
            & git commit -m "Replace 'Agung' with 'Josep' in views"
            if ($LASTEXITCODE -eq 0) {
                Write-Info "Commit berhasil."; exit 0
            } else {
                Write-Warn "Commit gagal. Silakan jalankan 'git commit' secara manual."; exit 0
            }
        } else {
            Write-Warn "'git apply' gagal. Melanjutkan ke fallback penggantian manual."
        }
    } else {
        Write-Warn "Patch tidak ada; langsung lakukan fallback penggantian manual."
    }
} else {
    Write-Warn "Git masih tidak tersedia — akan lakukan fallback penggantian manual di folder 'resources'."
}

# Fallback: cari file-file yang mengandung 'Agung' di dalam resources dan beberapa file proyek umum
$searchPaths = @(
    Join-Path $cwd 'resources',
    Join-Path $cwd '.'
)

Write-Info "Mencari kemunculan 'Agung' di folder 'resources' (dan subfolder) untuk diganti..."
$files = Get-ChildItem -Path (Join-Path $cwd 'resources') -Recurse -File -Include *.blade.php,*.php,*.md -ErrorAction SilentlyContinue | Where-Object {
    try { Select-String -Pattern 'Agung' -SimpleMatch -Path $_.FullName -Quiet } catch { $false }
}

if (-not $files -or $files.Count -eq 0) {
    Write-Info "Tidak ditemukan file yang mengandung 'Agung' di dalam 'resources'. Selesai."; exit 0
}

foreach ($f in $files) {
    $full = $f.FullName
    $bak = "$full.bak"
    try {
        Copy-Item -Path $full -Destination $bak -Force
        Write-Info "Backup dibuat: $bak"
        $content = Get-Content -Raw -Encoding UTF8 $full
        $new = $content -replace 'Agung','Josep'
        if ($new -ne $content) {
            Set-Content -Path $full -Value $new -Encoding UTF8
            Write-Info "Diubah: $full"
        } else {
            Write-Warn "Tidak ada perubahan untuk file: $full"
        }
    } catch {
        Write-Err "Gagal memodifikasi file: $full — $_"
    }
}

Write-Info "Selesai melakukan penggantian. Silakan cek hasil dan commit jika perlu."
Write-Info "Jika ingin commit otomatis dan Git sudah tersedia, jalankan:\n    git add -A; git commit -m \"Replace 'Agung' with 'Josep' in views\""
