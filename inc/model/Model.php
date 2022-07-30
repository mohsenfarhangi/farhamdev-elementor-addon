<?php


namespace SWPS\Inc\Model;


abstract class Model
{
    public string $table_name;

    protected $wpdb;

    protected string $table;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix . $this->table_name;
        $this->wpdb  = $wpdb;
    }

    /**
     * @param array $args
     * @return bool|int|\mysqli_result|resource
     */
    protected function insert($args = [])
    {
        $insert = $this->wpdb->insert(
            $this->table,
            $args
        );
        if (empty($insert)) $this->wpdb->error;
        else return $this->wpdb->insert_id;
    }

    protected function select($args, $select_all = true)
    {

        $columns    = $args['columns'] ?? '*';
        $join       = $args['join'] ?? '';
        $where      = $args['where'] ?? '';
        $order      = $args['order'] ?? '';
        $limit      = $args['per_page'] ?? '';
        $offset     = $args['start_at'] ?? '';
        $statements = $args['statements'] ?? '';

        $query = 'SELECT ';
        $query .= (is_array($columns)) ? implode(', ', $columns) : $columns;
        $query .= ' FROM `' . $this->table . '` ';
        if (!empty($join)) {
            $query .= $join;
        }
        $query .= (!empty($where)) ? ' WHERE ' : '';

        if (is_array($where)) {
            foreach ($where as $clause) {
                $query .= $clause . ' AND ';
            }
            $query = rtrim(trim($query), 'AND');
        } else {
            $query .= (is_string($where)) ? $where . ' ' : '';
        }

        if (is_array($order)) {
            foreach ($order as $value) {
                $query .= $value . ', ';
            }
            $query = rtrim(trim($query), ',');
        } else {
            $query .= (!empty($order)) ? ' ORDER BY ' : '';
            $query .= (is_string($order)) ? $order . ' ' : '';
        }

        if (!empty($limit)) {
            if (!empty($offset))
                $query .= ' LIMIT ' . $offset . ', ' . $limit;
            else
                $query .= ' LIMIT ' . $limit;
        }

        if (!empty($statements) && is_array($statements)) {
            return $this->statements(trim($query), $statements);
        }

        if ($select_all) return $this->wpdb->get_results(trim($query));
        else  return $this->wpdb->get_row(trim($query));


    }

    /**
     *
     * @param array $where ['ID' => 1]
     * @return bool|int
     */
    protected function delete(array $where)
    {
        return $this->wpdb->delete($this->table, $where);
    }

    /**
     * @param array $data ['column1' => 'value1','column2' => 'value2']
     * @param array $where ['ID' => 1]
     * @return bool|int
     */
    protected function update(array $data, array $where)
    {
        return $this->wpdb->update($this->table, $data, $where);
    }

    protected function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }
}