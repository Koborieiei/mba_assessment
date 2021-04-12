import React, { useState, useEffect } from "react";
import styled from "styled-components";
import QuestionContainer from "./QuestionContainer";
import TeacherSelector from "./TeacherSelector";
import HeaderSection from "./HeaderSection";
import TextAreaFullwidth from "./TextAreaFullwidth";
import { Button } from "@material-ui/core";
import { useForm } from "react-hook-form";
import axios from "axios";
import getQueryParams from "../utils/getQueryParam";
// import { Typography,Card } from "@material-ui/core";

const QuestionSection = styled.section`
  padding: 10px;
`;

export default function FormSection() {
  const [formState, setFormState] = useState([]);
  const [data, setData] = useState([]);
  const { control, handleSubmit } = useForm();
  const { uid, courseid } = getQueryParams();
  // const { uid, courseid } = getQueryParams();
  //   console.log(control);

  useEffect(() => {
    const fetchData = async () => {
      const params = { params: { courseid: courseid, uid: uid } };
      const url = "http://mbaonline.utcc.ac.th/api/getquestions.php";
      const req = await axios.get(url, params);
      //   setAssesmentInfo(req.data.assetmentid);
      setFormState({
        assessment_id: req.data.assetmentid,
        u_id: uid,
        course_id: courseid,
      });
      setData(req.data);
      console.log(data);
      // setData(req, data);
    };
    fetchData();
  }, []);

  const QuestionIndividual = () => {
    // console.log(questions);
    return data.questions.map((data) => {
      return (
        <QuestionContainer
          //   control={Controller}
          assess={control}
          key={data.question}
          question={data.question}
          items={data.items}
          questionId={data.id}
        />
      );
    });
  };

  // const TeacherSelector = () => {
  //   return data.teacher_list.map((teacher, index) => {
  //     return <QuestionContainer key={index} queti />;
  //   });
  // };

  const onSubmitHandle = async (formData) => {
    formState.questions = formData;
    // console.log(formState);
    try {
      const url = "http://mbaonline.utcc.ac.th/api/createassesment.php";
      const req = await axios.post(url, JSON.stringify(formState));
      const data = await req.data;
      // console.log(data);
      console.log(data);
    } catch (error) {
      console.log(error);
    }
    // let formData = new FormData(e.target);
    // //   console.log(assesmentInfo)
    // formData.append("questionid", JSON.stringify(assesmentInfo));
    // console.log(formData.getAll("questionid"));
  };

  return (
    <>
      {data.length !== 0 ? (
        <>
          <HeaderSection courseshortname={data.course_shortname} />
          <QuestionSection>
            <form onSubmit={handleSubmit(onSubmitHandle)}>
              <TeacherSelector
                teacherLists={data.teacher_list}
                assess={control}
              />
              <QuestionIndividual />
              <TextAreaFullwidth assess={control} />

              <Button
                type="submit"
                size="large"
                variant="contained"
                color="primary"
              >
                ยืนยัน
              </Button>
            </form>
          </QuestionSection>
        </>
      ) : (
        <> Loading </>
      )}
    </>
  );
}
