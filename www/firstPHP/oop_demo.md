# PHP 物件導向範例說明

此範例以「團隊薪資表」為主題，示範 PHP 物件導向的核心概念與常用語法。

## 範例檔案

- 範例程式：[firstPHP/oop_demo.php](firstPHP/oop_demo.php)
- 說明文件：[firstPHP/oop_demo.md](firstPHP/oop_demo.md)

## 教學重點

### 1. 類別與建構子

- 使用 `class` 定義類別
- 使用 `__construct()` 初始化物件

### 2. 封裝 (Encapsulation)

- 使用 `private`/`protected` 保護成員
- 透過 `getName()` 等方法存取資料

### 3. 繼承 (Inheritance)

- `Manager` 繼承 `Employee`
- 使用 `parent::` 呼叫父類別方法

### 4. 介面 (Interface)

- `Payable` 定義 `calculatePay()`
- `Employee` 與 `Manager` 實作介面

### 5. 抽象類別 (Abstract)

- `Person` 定義共用屬性與抽象方法
- 子類別必須實作 `getRole()`

### 6. 多型 (Polymorphism)

- 以 `Person` 型別儲存不同子類別物件
- 以 `Payable` 介面呼叫共同的方法

### 7. 靜態成員 (Static)

- `Team::$count` 紀錄團隊成員數量
- `Team::getCount()` 讀取統計值

## 程式碼摘要

```php
interface Payable
{
    public function calculatePay(): int;
}

abstract class Person
{
    protected string $name;
    public function __construct(string $name) { $this->name = $name; }
    public function getName(): string { return $this->name; }
    abstract public function getRole(): string;
}

class Employee extends Person implements Payable
{
    private int $monthlySalary;
    public function __construct(string $name, int $monthlySalary)
    {
        parent::__construct($name);
        $this->monthlySalary = $monthlySalary;
    }
    public function getRole(): string { return 'Employee'; }
    public function calculatePay(): int { return $this->monthlySalary; }
}

class Manager extends Employee
{
    private int $bonus;
    public function __construct(string $name, int $monthlySalary, int $bonus)
    {
        parent::__construct($name, $monthlySalary);
        $this->bonus = $bonus;
    }
    public function getRole(): string { return 'Manager'; }
    public function calculatePay(): int { return parent::calculatePay() + $this->bonus; }
}
```

## 執行方式

1. 使用瀏覽器開啟：`http://localhost/firstPHP/oop_demo.php`
2. 頁面會顯示：
   - 成員姓名與角色
   - 依多型計算的薪資
   - 團隊總人數（static）

## 延伸練習

- 新增 `Intern` 類別，薪資以時薪計算
- 在 `Team` 加入 `removeMember()` 方法
- 讓 `Manager` 具有 `department` 屬性
