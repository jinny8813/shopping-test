import { useRef, useState } from "react";
import { Editor } from "@tinymce/tinymce-react";
import { Button } from "react-bootstrap";

export const EditorComponent = (props) => {
  const editorRef = useRef(null);
  const [content, setContent] = useState();

  const log = () => {
    if (editorRef.current) {
      const currentContent = editorRef.current.getContent();
      setContent(currentContent);
      console.log(currentContent);
    }
  };

  return (
    <div style={{ border: "1px solid #888888", height: "600px" }}>
      <Editor
        apiKey="ew59f90ld4utt1o6wl58amnl2r0ene9euagh4rxwgd6vfpf6"
        onInit={(_evt, editor) => (editorRef.current = editor)}
        init={{
          plugins:
            "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown",
          toolbar:
            "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
          tinycomments_mode: "embedded",
          tinycomments_author: "Author name",
          mergetags_list: [
            { value: "First.Name", title: "First Name" },
            { value: "Email", title: "Email" },
          ],
          ai_request: (request, respondWith) =>
            respondWith.string(() =>
              Promise.reject("See docs to implement AI Assistant")
            ),
        }}
        initialValue="Welcome to TinyMCE!"
      />
      <Button onClick={log}>Log editor content</Button>
      <br />
      <>{content}</>
    </div>
  );
};
