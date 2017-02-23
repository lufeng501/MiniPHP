<?php
namespace Example;
/**
 * PSR4自动加载类
 * 使用方法：
 *      <?php
 *      // 实例化 the loader
 *      $loader = new \Example\Psr4AutoloaderClass;
 *
 *      // 注册 the autoloader
 *      $loader->register();
 *
 *      // 配置命名空间前缀
 *      $loader->addNamespace('Foo\Bar', __DIR__ . "/lib");
 *
 */
class Psr4AutoloaderClass
{
    /**
     * 定义一个数组变量存放命名空间前缀配置的路径地址
     */
    protected $prefixes = array();

    /**
     * 在 SPL 自动加载器栈中注册加载器
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * 添加命名空间前缀与文件基目录对
     *
     * @param string $prefix 命名空间前缀
     * @param string $base_dir 命名空间中类文件的基目录
     * @param bool $prepend 为 True 时，将基目录插到最前，这将让其作为第一个被搜索到，否则插到将最后。
     * @return void
     *
     * DIRECTORY_SEPARATOR 宏变量 "/"
     */
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // 规范化命名空间前缀
        $prefix = trim($prefix, '\\') . '\\';  //移出两边的'\'符号后右尾端加上'\'符号，比如：Foo\Bar\

        // 规范化文件基目录
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // 初始化命名空间前缀数组
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }

        // 将命名空间前缀与文件基目录对插入保存数组
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $base_dir);
        } else {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

    /**
     * 由类名载入相应类文件
     *
     * @param string $class 完整的类名
     * @return mixed 成功载入则返回载入的文件名，否则返回布尔 false
     */
    public function loadClass($class)
    {
        // 完整的类名作为当前命名空间前缀
        $prefix = $class;
        //从完整的类名按照'\'符号遍历切分匹配命名空间前缀
        while (false !== $pos = strrpos($prefix, '\\')) { //匹配'\'的位置

            // 切割命名空间前缀
            $prefix = substr($class, 0, $pos + 1);

            // 剩下字符串段为对应的类名称
            $relative_class = substr($class, $pos + 1);

            // 尝试加载前缀和相对类的映射文件
            $mapped_file = $this->loadMappedFile($prefix, $relative_class);

            if ($mapped_file) { // 匹配成功加载对应文件直接返回
                return $mapped_file;
            }else{
                // 删除下一次迭代的尾随命名空间分隔符
                $prefix = rtrim($prefix, '\\');
            }
        }
        // 找不到相应文件
        return false;
    }

    /**
     * 加载命名空间前缀和相关类的映射文件
     *
     * @param string $prefix 命名空间前缀.
     * @param string $relative_class 相对路径的类名称.
     * @return mixed Boolean 成功映射就返回true,否则返回false
     */
    protected function loadMappedFile($prefix, $relative_class)
    {
        // 判断$prefix是否定义并且已经存有命名空间前缀数据
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        // 遍历$prefix组装文件的绝对路径
        foreach ($this->prefixes[$prefix] as $base_dir) {

            $file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';

            // 当文件存在时，加载文件
            if ($this->requireFile($file)) {
                // 完成载入
                return $file;
            }
        }

        // 找不到相应文件
        return false;
    }

    /**
     * 当文件存在，则从文件系统载入之
     *
     * @param string $file 需要载入的文件
     * @return bool 当文件存在则为 True，否则为 false
     */
    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}