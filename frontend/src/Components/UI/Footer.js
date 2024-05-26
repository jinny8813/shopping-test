import { Footer as AntdFooter } from "antd/es/layout/layout";

const Footer = () => {
  return (
    <AntdFooter
      style={{
        textAlign: "center",
      }}
    >
      騏騏資訊 ©{new Date().getFullYear()} Created by 騏騏資訊
    </AntdFooter>
  );
};

export default Footer;
