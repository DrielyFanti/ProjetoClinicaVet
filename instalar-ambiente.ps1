# instalar-ambiente.ps1
# Executar como administrador (clicar com o botão direito > "Executar com o PowerShell")

Write-Host "==== Instalando ambiente para projeto Laravel ====" -ForegroundColor Cyan

# Verifica se o Chocolatey está instalado
if (!(Get-Command choco -ErrorAction SilentlyContinue)) {
    Write-Host "Chocolatey não encontrado. Instalando Chocolatey..." -ForegroundColor Yellow

    Set-ExecutionPolicy Bypass -Scope Process -Force
    [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
    Invoke-Expression ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))
} else {
    Write-Host "Chocolatey já está instalado." -ForegroundColor Green
}

# Atualiza o Chocolatey
choco upgrade chocolatey -y

# Instala PHP (v8.2), Composer e MySQL
choco install php --version=8.2.19 -y
choco install composer -y
choco install mysql -y

# Exibe versão instalada de cada um
php -v
composer -V
mysql --version

Write-Host "`n==== Instalação concluída ====" -ForegroundColor Green
Write-Host "Reinicie o terminal se for necessário." -ForegroundColor Yellow

pause