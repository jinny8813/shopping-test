import { DownOutlined } from "@ant-design/icons";
import { Dropdown as AntdDropdown, Space } from "antd";

const Dropdown = () => {
  const items = [
    {
      key: "1",
      label: (
        <a
          target="_blank"
          rel="noopener noreferrer"
          href="https://www.antgroup.com"
        >
          熱門度
        </a>
      ),
    },
    {
      key: "2",
      label: (
        <a
          target="_blank"
          rel="noopener noreferrer"
          href="https://www.aliyun.com"
        >
          價格(高-{">"}低)
        </a>
      ),
    },
    {
      key: "3",
      label: (
        <a
          target="_blank"
          rel="noopener noreferrer"
          href="https://www.luohanacademy.com"
        >
          價格(低-{">"}高)
        </a>
      ),
    },
    {
      key: "4",
      label: (
        <a
          target="_blank"
          rel="noopener noreferrer"
          href="https://www.luohanacademy.com"
        >
          上架時間(舊-{">"}新)
        </a>
      ),
    },
    {
      key: "5",
      label: (
        <a
          target="_blank"
          rel="noopener noreferrer"
          href="https://www.luohanacademy.com"
        >
          上架時間(新-{">"}舊)
        </a>
      ),
    },
  ];

  return (
    <AntdDropdown
      menu={{
        items,
      }}
    >
      <a onClick={(e) => e.preventDefault()}>
        <Space>
          依條件排序
          <DownOutlined />
        </Space>
      </a>
    </AntdDropdown>
  );
};

export default Dropdown;
