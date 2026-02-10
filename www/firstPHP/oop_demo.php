<?php
// OOP demo for PHP: class, constructor, encapsulation, inheritance, interface, static, abstract.

header('Content-Type: text/html; charset=utf-8');

interface Payable
{
    public function calculatePay(): int;
}

abstract class Person
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

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

    public function getRole(): string
    {
        return 'Employee';
    }

    public function calculatePay(): int
    {
        return $this->monthlySalary;
    }
}

class Manager extends Employee
{
    private int $bonus;

    public function __construct(string $name, int $monthlySalary, int $bonus)
    {
        parent::__construct($name, $monthlySalary);
        $this->bonus = $bonus;
    }

    public function getRole(): string
    {
        return 'Manager';
    }

    public function calculatePay(): int
    {
        return parent::calculatePay() + $this->bonus;
    }
}

class Team
{
    private array $members = [];
    private static int $count = 0;

    public function addMember(Person $person): void
    {
        $this->members[] = $person;
        self::$count += 1;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public static function getCount(): int
    {
        return self::$count;
    }
}

function money(int $amount): string
{
    return '$' . number_format($amount);
}

$team = new Team();
$team->addMember(new Employee('Alice', 40000));
$team->addMember(new Manager('Bob', 60000, 15000));

$rows = [];
foreach ($team->getMembers() as $member) {
    if ($member instanceof Payable) {
        $rows[] = [
            'name' => $member->getName(),
            'role' => $member->getRole(),
            'pay' => money($member->calculatePay()),
        ];
    }
}
?>
<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>PHP 物件導向範例</title>
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Arial, sans-serif; margin: 24px; }
        table { border-collapse: collapse; width: 100%; max-width: 640px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        code { background: #f4f4f4; padding: 2px 4px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>PHP 物件導向範例</h1>

    <p>
        本頁展示 <code>class</code>、<code>interface</code>、<code>abstract</code>、
        繼承、封裝、靜態成員、型別提示與多型的概念。
    </p>

    <h2>成員薪資表</h2>
    <table>
        <thead>
            <tr>
                <th>姓名</th>
                <th>角色</th>
                <th>薪資</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['pay'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>團隊總人數（static）：<?= Team::getCount() ?></p>
</body>
</html>
