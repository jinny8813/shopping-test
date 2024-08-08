import { Link } from "react-router-dom";
import { Breadcrumb as AntdBreadcrumb } from "antd";

const Breadcrumb = ({ title }) => {
  return (
    <AntdBreadcrumb
      items={[
        {
          title: <Link to="/">首頁</Link>,
        },
        {
          title: <a href="#">線上商店</a>,
        },
        {
          title: title,
        },
      ]}
      style={{ paddingBottom: "2rem" }}
    />
  );
};

export default Breadcrumb;
