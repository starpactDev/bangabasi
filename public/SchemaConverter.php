<?php

class SchemaConverter
{
    private $pdo;
    
    public function __construct($host, $dbname, $username, $password)
    {
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }
    
    public function convertTableToLaravelSchema($tableName)
    {
        // Get column information
        $stmt = $this->pdo->prepare("DESCRIBE $tableName");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get indexes
        $stmt = $this->pdo->prepare("SHOW INDEXES FROM $tableName");
        $stmt->execute();
        $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $output = "Schema::create('$tableName', function (Blueprint \$table) {\n";
        
        // Process columns
        foreach ($columns as $column) {
            $line = $this->convertColumnToLaravel($column);
            $output .= "    " . $line . "\n";
        }
        
        // Process indexes
        $processedIndexes = [];
        foreach ($indexes as $index) {
            if (!in_array($index['Key_name'], $processedIndexes)) {
                $line = $this->convertIndexToLaravel($index);
                if ($line) {
                    $output .= "    " . $line . "\n";
                }
                $processedIndexes[] = $index['Key_name'];
            }
        }
        
        $output .= "});";
        return $output;
    }
    
    private function convertColumnToLaravel($column)
    {
        $name = $column['Field'];
        $type = strtolower($column['Type']);
        $nullable = $column['Null'] === 'YES';
        $default = $column['Default'];
        
        // Extract type and length
        preg_match('/([a-z]+)(?:\(([^)]+)\))?/', $type, $matches);
        $baseType = $matches[1];
        $length = $matches[2] ?? null;
        
        $line = "\$table->";
        
        // Map MySQL types to Laravel column types
        switch ($baseType) {
            case 'int':
                $line .= 'integer';
                break;
            case 'varchar':
                $line .= "string";
                if ($length) {
                    $line .= "($length)";
                }
                break;
            case 'text':
                $line .= 'text';
                break;
            case 'datetime':
                $line .= 'datetime';
                break;
            case 'timestamp':
                $line .= 'timestamp';
                break;
            case 'decimal':
                $precision = explode(',', $length)[0];
                $scale = explode(',', $length)[1];
                $line .= "decimal($precision, $scale)";
                break;
            default:
                $line .= $baseType;
        }
        
        $line .= "('$name')";
        
        // Add modifiers
        if ($nullable) {
            $line .= '->nullable()';
        }
        if ($default !== null) {
            if ($default === 'CURRENT_TIMESTAMP') {
                $line .= '->useCurrent()';
            } else {
                $line .= "->default('$default')";
            }
        }
        if ($column['Extra'] === 'auto_increment') {
            $line .= '->autoIncrement()';
        }
        
        return $line . ';';
    }
    
    private function convertIndexToLaravel($index)
    {
        $keyName = $index['Key_name'];
        $columnName = $index['Column_name'];
        
        if ($keyName === 'PRIMARY') {
            return null; // Primary key is usually handled by autoIncrement()
        }
        
        if ($index['Non_unique'] == 0) {
            return "\$table->unique('$columnName');";
        } else {
            return "\$table->index('$columnName');";
        }
    }
}

// Example usage:

$converter = new SchemaConverter('localhost', 'bangobasi3', 'root', '');
$schema = $converter->convertTableToLaravelSchema('products');
echo $schema;
