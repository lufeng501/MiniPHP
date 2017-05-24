<?php
/**
 * Des : ORM操作类
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/24
 * Time: 11:48
 */

namespace Framework\orm;


use Framework\App;

class DB
{
    /**
     * Sql解释器
     */
    use Interpreter;
    // 实例对象
    public static $_instance;
    // 表名
    public $tableName;
    // 数据库配置
    public $dbConfig;
    // 数据库实例
    public $dbInstance;

    /**
     * 单例类，防止new实例化
     *
     * DB constructor.
     */
    private function __construct()
    {
    }

    /**
     * 初始化策略(PDO)
     *
     * @return void
     */
    public static function init()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        self::$_instance->dbInstance = App::$container->getSingleInstance(\Framework\orm\db\Pdo::class);
        return self::$_instance;
    }

    /**
     * 设置表名
     *
     * @param string $tableName 表名称
     * @return void
     */
    public static function table($tableName = '')
    {
        self::init();
        self::$_instance->tableName = $tableName;
        return self::$_instance;
    }

    /**
     * 设置sql语句
     *
     * @param $sql
     * @return DB
     */
    public static function query($sql)
    {
        self::init();
        self::$_instance->sql = $sql;
        return self::$_instance;
    }

    /**
     * 构建sql语句
     *
     * @return void
     */
    public function buildSql()
    {
        if (! empty($this->where)) {
            $this->sql .= $this->where;
        }
        if (! empty($this->orderBy)) {
            $this->sql .= $this->orderBy;
        }
        if (! empty($this->limit)) {
            $this->sql .= $this->limit;
        }
    }

    /**
     * 查找所有数据
     *
     * @param  array $data 查询的字段
     * @return void
     */
    public function findAll($data = [])
    {
        $this->select($data);
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 执行sql语句获取结果
     *
     * @return mixed
     */
    public function get()
    {
        return $this->dbInstance->query($this->sql);
    }
}