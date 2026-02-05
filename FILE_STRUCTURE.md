# 儲存庫檔案結構詳細說明


## 目錄樹狀結構

```
database-programming-course/
├── README.md                           # 主要說明文件
├── .gitignore                          # Git 忽略規則
├── FILE_STRUCTURE.md                   # 本檔案
│
├── syllabus/
│   └── SYLLABUS.md                     # 16 週完整教學大綱
│
├── www/
│   └── first/
│   │   ├── README.md                  # 說明
│   │   ├── f01.html
|   |   ├── ...           
│   ...
|
├── assignments/                        # 作業資源
│   ├── hw1/                           # 作業 1：留言板
│   │   ├── docs/
│   │   │   └── README.md              # 作業說明
│   │   ├── code/                      # 範例程式碼
│   │   └── sql/
│   │       └── init.sql               # 資料庫初始化
│   │
│   ├── hw2/                           # 作業 2：會員系統
│   │   ├── docs/
│   │   │   └── README.md
│   │   ├── code/
│   │   └── sql/
│   │       └── init.sql
│   │
│   ├── hw3/                           # 作業 3：投票系統
│   │   ├── docs/
│   │   │   └── README.md
│   │   ├── code/
│   │   └── sql/
│   │       └── init.sql
│   │
│   ├── hw4/                           # 作業 4：購物車
│   │   ├── docs/
│   │   │   └── README.md
│   │   ├── code/
│   │   └── sql/
│   │
│   ├── hw5/                           # 作業 5：網路相簿
│   │   ├── docs/
│   │   │   └── README.md
│   │   ├── code/
│   │   └── sql/
│   │       └── init.sql
│   │
│   └── final-project/                 # 期末專案：電子商務網站
│       ├── docs/
│       │   └── README.md              # 專案說明
│       ├── code/
│       └── sql/
│           └── init.sql               # 完整資料庫結構
│
└── resources/                          # 學習資源
    └── (可放置額外參考資料)
```

## 檔案詳細清單

### 核心文件 (3 個)
- `README.md` - 課程總覽與使用說明
- `.gitignore` - Git 配置
- `FILE_STRUCTURE.md` - 本檔案

### 課程大綱 (1 個)
- `syllabus/COMPLETE_SYLLABUS.md` - 完整 16 週大綱

### 投影片 (48 個)
- 每週 3 種格式：Markdown、HTML、PDF
- 共 16 週 × 3 種格式 = 48 個投影片檔案

### 範例程式碼 (16 個)
- `weeks/01-16/examples/README.md` - 各週範例說明

### 作業文件 (11 個)
- 5 個小型作業：`hw1/docs/README.md` 到 `hw5/docs/README.md`
- 1 個期末作業：`final-project/docs/README.md`
- 4 個作業 4 的補充說明

### SQL 初始化腳本 (6 個)
- `hw1/sql/init.sql` - 留言板資料庫
- `hw2/sql/init.sql` - 會員系統資料庫
- `hw3/sql/init.sql` - 投票系統資料庫
- `hw5/sql/init.sql` - 網路相簿資料庫
- `final-project/sql/init.sql` - 電子商務資料庫
- (hw4 無需資料庫，使用 Cookie)

## 使用指南

### 1. 解壓縮
```bash
tar -xzf database-programming-course.tar.gz
cd database-programming-course
```

### 2. 查看課程大綱
```bash
cat syllabus/COMPLETE_SYLLABUS.md
```

### 3. 查看特定週次的投影片
```bash
# Markdown 格式
cat weeks/01/slides/lecture.md

# HTML 格式（在瀏覽器中打開）
open weeks/01/slides/lecture.html

# PDF 格式（用 PDF 閱讀器打開）
open weeks/01/slides/lecture.pdf
```

### 4. 查看作業說明
```bash
cat assignments/hw1/docs/README.md
```

### 5. 初始化作業資料庫
```bash
# 在 MySQL 中執行
mysql -u root -p < assignments/hw1/sql/init.sql
```

## 技術棧涵蓋

| 技術 | 檔案位置 | 週次 |
|:---|:---|:---|
| HTML5 | weeks/02/ | 第 2 週 |
| CSS3 | weeks/03/ | 第 3 週 |
| JavaScript | weeks/04/ | 第 4 週 |
| PHP 基礎 | weeks/05/ | 第 5 週 |
| MySQL | weeks/06/ | 第 6 週 |
| PDO | weeks/07/ | 第 7 週 |
| 實務應用 | assignments/hw1-5/ | 第 8-14 週 |
| Laravel | weeks/15/ | 第 15 週 |
| 期末專案 | assignments/final-project/ | 第 16 週 |

## 作業對應表

| 作業 | 週次 | 技術重點 | 檔案位置 |
|:---|:---|:---|:---|
| HW1 | 08 | CRUD、PDO | assignments/hw1/ |
| HW2 | 10 | Session、寄信、上傳 | assignments/hw2/ |
| HW3 | 11 | PHP GD、圖表 | assignments/hw3/ |
| HW4 | 13 | Cookie、購物車 | assignments/hw4/ |
| HW5 | 14 | 圖片處理、縮圖 | assignments/hw5/ |
| Final | 16 | 整合所有技術 | assignments/final-project/ |

## 投影片格式說明

### Markdown 格式 (.md)
- 優點：易於版本控制、GitHub 直接預覽
- 用途：在 GitHub 或 Markdown 編輯器中查看
- 位置：`weeks/*/slides/lecture.md`

### HTML 格式 (.html)
- 優點：可在瀏覽器中直接打開、支援互動
- 用途：在線上課程中使用
- 位置：`weeks/*/slides/lecture.html`

### PDF 格式 (.pdf)
- 優點：適合列印、離線查看、分享
- 用途：下載後離線使用、投影展示
- 位置：`weeks/*/slides/lecture.pdf`

## 快速開始

1. **下載儲存庫**
   ```bash
   git clone <repository-url>
   # 或解壓縮 tar.gz 檔案
   ```

2. **瀏覽課程內容**
   ```bash
   cat README.md
   cat syllabus/COMPLETE_SYLLABUS.md
   ```

3. **查看投影片**
   - 在瀏覽器中打開 `weeks/*/slides/lecture.html`
   - 或使用 PDF 閱讀器打開 `weeks/*/slides/lecture.pdf`

4. **開始作業**
   - 閱讀 `assignments/hw*/docs/README.md`
   - 在 `assignments/hw*/code/` 中編寫程式碼
   - 使用 `assignments/hw*/sql/init.sql` 初始化資料庫

## 常見問題

**Q: 如何在 Laragon 中使用這些資源？**
A: 將 `weeks/*/examples/` 中的檔案複製到 Laragon 的 `www` 目錄，然後在瀏覽器中訪問。

**Q: 投影片可以編輯嗎？**
A: 可以。Markdown 檔案可以用任何文字編輯器編輯，HTML 檔案可以用瀏覽器開發者工具修改。

**Q: 如何提交作業？**
A: 在 `assignments/hw*/code/` 中完成程式碼，然後提交至 GitHub 或郵件。

**Q: 資料庫初始化腳本如何使用？**
A: 在 MySQL 命令行中執行 `mysql -u root -p < assignments/hw*/sql/init.sql`

## 更新日誌

- **2026-01-28**：初版發佈，包含 16 週完整課程內容、5 個作業、1 個期末專案

## 授權

本課程資源採用 MIT 授權。詳見 LICENSE 檔案。

---
