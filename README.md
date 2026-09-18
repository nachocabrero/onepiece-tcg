# 🃏 One Piece TCG Collection Manager

Gestiona y consulta tu colección de cartas del **One Piece Trading Card Game**.

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite)

**📊 4,717 cartas** · **67 sets** · **1,906 variaciones**

</div>

---

## 📋 Descripción

Aplicación web para gestionar la colección completa de cartas del One Piece TCG. Incluye datos de todos los sets oficiales (OP01-OP17, PRB01, PRB02) y sus variaciones.

## ✨ Características

- 📖 Base de datos completa con **4,717 cartas**
- 🃏 **67 sets** oficiales documentados
- 🔍 Búsqueda y filtrado de cartas
- 📊 Estadísticas de colección
- 🔄 Script de actualización automática (`update.sh`)

## 📦 Datos

- **Cartas totales:** 4,717
- **Sets oficiales:** 67
- **Variaciones:** 1,906 (de 19 sets)
- **Formato de datos:** JSON (`all_variations.json`)

## 🛠️ Instalación

```bash
# Clonar el repositorio
git clone https://github.com/nachocabrero/onepiece-tcg.git
cd onepiece-tcg

# Instalar dependencias
composer install

# Configurar y ejecutar
php artisan serve
```

## 🔄 Actualización de datos

```bash
# Ejecutar el script de actualización
./update.sh
```

## 📁 Estructura

```
onepiece-tcg/
├── app/
├── database/
├── public/
│   └── all_variations.json
├── update.sh
└── README.md
```

## 📄 Licencia

Proyecto personal de coleccionismo.

---

<div align="center">

Hecho con ❤️ por **Nacho Cabrero** · Granada, España

</div>
