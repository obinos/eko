<?php
class ServerSide_DT
{
    public function __construct()
    {
        $this->CI = get_instance();
    }
    private function params()
    {
        $params['search'] = $_POST['search']['value'];
        $params['limit'] = $_POST['length'];
        $params['start'] = $_POST['start'];
        $order_field = $_POST['order'][0]['column'];
        $ascdesc = $_POST['order'][0]['dir'];
        $order_data = $_POST['columns'][$order_field]['data'];
        $params['$order'] = [$order_data => $ascdesc];
        return $params;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search, $collection)
    {
        $result['all_data'] = $this->CI->mongo_db->where($where)->count($collection);
        $result['show_data'] = $this->CI->mongo_db->order_by($order)->get_where($collection, $where);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->CI->mongo_db->order_by($order)->get_where($collection, $where);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->CI->mongo_db->limit($limit)->offset($start)->order_by($order)->get_where($collection, $where);
        }
        return $result;
    }
    private function callback($result)
    {
        $callback = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $result['all_data'],
            'recordsFiltered' => $result['filter_data'],
            'data' => $result['show_data']
        );
        return $callback;
    }
    function serverside($where_search, $collection)
    {
        $filter_event = $this->CI->session->userdata('filter_event');
        $params = $this->params();
        $where = ['$nor' => [['_id' => null]]];
        $where_event = ['event_code' => $filter_event];
        if ($filter_event) {
            $where = array_merge($where, $where_event);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $where_search, $collection);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
